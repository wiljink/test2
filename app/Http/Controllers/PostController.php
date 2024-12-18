<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PostController extends Controller
{
    //
    public function create()
    {
        $response = Http::get('https://loantracker.oicapp.com/api/v1/branches');
        $branches = $response->json();
        return view(
            'posts.create',
            [
                'branches' => $branches['branches'],
            ]
        );
    }

    public function store(Request $request)
    {

        //Validate the request
        $data = $request->validate([
            'post_id' => 'nullable|integer',
            'name' => 'required',
            'branch' => 'required|string',
            'contact_number' => 'required|regex:/^[0-9]+$/',
            'concern' => 'required|string',
            'message' => 'required|string',
            // Optional fields since they are nullable in the database
            'endorse_by' => 'nullable|string|max:255',
            'endorse_to' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $post = POST::create($data);

        //redirect to index page
        // return redirect(route('posts.index'));
        return redirect()->route('posts.create')->with('success', '<span style="color: red;">Thank you for posting your concern. A Branch Representative will contact you soon.</span>');
    }

    public function update(Request $request)
    {

        // Validate the incoming request data
        $data = $request->validate([
            'post_id' => 'required|integer',
            'endorse_to' => 'required|string',
            'endorse_by' => 'required|integer', // Authenticated user's ID
        ]);

        // Find the post by its ID
        $post = Post::findOrFail($data['post_id']);
        $post->endorsed_date = Carbon::now();  // Set the current date and time
        // Update the post with the validated data
        $post->endorse_to = $data['endorse_to'];
        $post->endorse_by = $data['endorse_by']; // Store the user who prepared the endorsement
        $post->status = 'Endorsed'; // Set status to "Pending"
        $post->save();

        // Return a success response with the post ID
        return response()->json([
            'success' => true,
            'post_id' => $post->id,  // Include the post_id for the frontend to use
        ]);




        //return redirect()->route('posts.index')->with('success', '<span style="color: red;">Concern Successfully Endorsed</span>');
    }


    public function index(Request $request)
    {
        // Fetch branch data from the external API
        $response1 = Http::get('https://loantracker.oicapp.com/api/v1/branches');
        $branches = $response1->json();
    
        // Get the authenticated user's data
        $token = session('token');
        $response2 = Http::withToken($token)->get("https://loantracker.oicapp.com/api/v1/users/logged-user");
        $authenticatedUser = $response2->json();
        
    
        // Retrieve posts based on the authenticated user's branch ID or endorse_to field
        if ($authenticatedUser['user']['branch_id'] === 23) {
            $posts = Post::paginate(10);
        } else {
            $posts = Post::where('branch', $authenticatedUser['user']['branch_id'])
                         ->orWhere('endorse_to', $authenticatedUser['user']['oid'])
                         ->paginate(10);
        }
    
        // Loop through posts to map 'endorse_by' to 'endorse_by_fullname'
        foreach ($posts as $post) {
            if ($post->endorse_by) {
                // Fetch user by 'endorse_by' oid
                $response3 = Http::withToken($token)->get("https://loantracker.oicapp.com/api/v1/users/{$post->endorse_by}");
                

                
                // Check if the API call was successful
                if ($response3->successful()) {
                    //dd($response3->status(), $response3->body());
                    $user = $response3->json(); // Parse user data
                    // dd($user);
                    $post->endorse_by_fullname = $user['user']['officer']['fullname'] ?? 'N/A';
                    // dd($post);
                    

                } else {
                    $post->endorse_by_fullname = 'N/A'; // If the user is not found
                    
                }
            } else {
                $post->endorse_by_fullname = 'N/A'; // If 'endorse_by' is null
            }
            
        }
    
        // Return the view with the posts and other data
        return view('posts.index', [
            'data' => $posts,
            'branches' => $branches['branches'],
            'authenticatedUser' => $authenticatedUser['user'],
            
        ]);
       
    }
    

    public function analyze(Request $request)
{
    try {
        // Validate incoming request data
        $validatedData = $request->validate([
            'posts_id' => 'required|integer|exists:posts,id',
            'status' => 'required|string|in:In Progress,Resolved',
            'tasks' => 'nullable|array',
            'removed_tasks' => 'nullable|array', // Accept removed tasks
        ]);

        // Find the post by ID
        $post = Post::find($validatedData['posts_id']);

        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }

        // Decode the existing tasks from the database
        $existingTasks = $post->tasks ? json_decode($post->tasks, true) : [];

        // Update tasks if provided
        if (!empty($validatedData['tasks'])) {
            // Merge the new tasks with existing tasks and remove duplicates
            $existingTasks = array_unique(array_merge($existingTasks, $validatedData['tasks']));
        }

        // Remove tasks if any are provided in removed_tasks
        if (!empty($validatedData['removed_tasks'])) {
            // Filter out removed tasks from the existing tasks
            $existingTasks = array_filter($existingTasks, function ($task) use ($validatedData) {
                return !in_array($task, $validatedData['removed_tasks']);
            });
        }

        // Save the updated tasks back to the database
        $post->tasks = json_encode(array_values($existingTasks)); // Re-index tasks to ensure valid JSON

        // Handle status updates
        $currentTime = Carbon::now(); // Capture the current time once
        $status = $validatedData['status'];

        if ($status === 'In Progress') {
            $post->status = 'In Progress';
        } elseif ($status === 'Resolved') {
            if (!$post->endorsed_date) {
                $post->endorsed_date = $currentTime;
            }

            $post->status = 'Resolved';
            $post->resolved_date = $currentTime;

            $endorsedDate = Carbon::parse($post->endorsed_date);
            $resolvedDays = $endorsedDate->diff($currentTime);

            $post->resolved_days = json_encode([
                'total_difference' => $resolvedDays->format('%a days, %h hours, %i minutes, %s seconds'),
                'days' => $resolvedDays->d,
                'hours' => $resolvedDays->h,
                'minutes' => $resolvedDays->i,
                'seconds' => $resolvedDays->s,
            ]);
        }

        // Save the updated post
        $post->save();

        // Redirect to the posts.index route with a success message
        $message = $status === 'Resolved' 
            ? 'Concern successfully resolved.' 
            : 'Progress saved successfully.';
        return redirect()->route('posts.index')->with('success', $message);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        // Handle any other exceptions
        return redirect()->back()->with('error', $e->getMessage());
    }
}



public function resolved()
{
    // Fetch branch data from the API
    $response1 = Http::get('https://loantracker.oicapp.com/api/v1/branches');
    $branches = $response1->json(); // This will hold the branch data

    // Fetch authenticated user's information
    $token = session('token');
    $response2 = Http::withToken($token)->get("https://loantracker.oicapp.com/api/v1/users/logged-user");
    $authenticatedUser = $response2->json();

    // Check if branch_id is 23 (admin or specific branch condition)
    if ($authenticatedUser['user']['branch_id'] === 23) {
        // If the branch is 23, fetch all posts
        $posts = Post::whereNotNull('created_at')
            ->whereNotNull('endorsed_date')
            ->get();
    } else {
        // Otherwise, fetch posts only for the authenticated user's branch
        $posts = Post::whereNotNull('created_at')
            ->whereNotNull('endorsed_date')
            ->where('branch', $authenticatedUser['user']['branch_id']) // Filter by branch
            ->get();
    }

    // Group posts by branch
    $groupedPosts = $posts->groupBy('branch');

    // Initialize an array to hold average facilitation times for each branch and concern
    $averagesByBranch = [];

    // Loop through each branch
    foreach ($groupedPosts as $branch => $branchPosts) {
        // Fetch the branch name from the branch data using the branch_id
        $branchName = collect($branches['branches'])->firstWhere('id', $authenticatedUser['user']['branch_id'])['branch_name'] ?? 'Unknown Branch';

        // Group posts by concern within the branch
        $postsByConcern = $branchPosts->groupBy('concern');

        foreach ($postsByConcern as $concern => $concernPosts) {
            // Exclude posts with null or empty concern
            if (empty($concern)) {
                continue;
            }

            $totalSeconds = 0;
            $totalPosts = count($concernPosts);

            foreach ($concernPosts as $post) {
                // Calculate the difference in seconds between concern_received_date and endorsed_date
                $receivedDate = \Carbon\Carbon::parse($post->concern_received_date);
                $endorsedDate = \Carbon\Carbon::parse($post->endorsed_date);

                $diffInSeconds = $endorsedDate->diffInSeconds($receivedDate);

                $totalSeconds += $diffInSeconds;
            }

            // Calculate the average time in seconds for this concern
            if ($totalPosts > 0) {
                $averageSeconds = $totalSeconds / $totalPosts;

                // Convert seconds into days, hours, minutes, and seconds
                $averageDays = floor($averageSeconds / 86400);
                $averageSeconds %= 86400;
                $averageHours = floor($averageSeconds / 3600);
                $averageSeconds %= 3600;
                $averageMinutes = floor($averageSeconds / 60);
                $averageSeconds %= 60;

                // Store the average facilitation time for the concern
                $averagesByBranch[$branch]['branch_name'] = $branchName; // Store branch name
                $averagesByBranch[$branch][$concern] = [
                    'days' => $averageDays,
                    'hours' => $averageHours,
                    'minutes' => $averageMinutes,
                    'seconds' => $averageSeconds
                ];
            }
        }
    }

    // Pass the data to the view
    return view('posts.resolved', compact('averagesByBranch'));
}





    public function facilitate()
    {
        // Retrieve all concerns with a valid concern_received_date and endorsed_date
        $posts = Post::whereNotNull('created_at')
            ->whereNotNull('endorsed_date')
            ->get();

// Group posts by branch
        $groupedPosts = $posts->groupBy('branch');

// Initialize an array to hold average facilitation times for each branch and concern
        $averagesByBranch = [];

// Loop through each branch
        foreach ($groupedPosts as $branch => $branchPosts) {
// Group posts by concern within the branch
            $postsByConcern = $branchPosts->groupBy('concern');

            foreach ($postsByConcern as $concern => $concernPosts) {
                $totalSeconds = 0;
                $totalPosts = count($concernPosts);

                foreach ($concernPosts as $post) {
                    // Calculate the difference in seconds between concern_received_date and endorsed_date
                    $receivedDate = \Carbon\Carbon::parse($post->concern_received_date);
                    $endorsedDate = \Carbon\Carbon::parse($post->endorsed_date);

                    $diffInSeconds = $endorsedDate->diffInSeconds($receivedDate);

                    $totalSeconds += $diffInSeconds;
                }

// Calculate the average time in seconds for this concern
                $averageSeconds = $totalSeconds / $totalPosts;

// Convert seconds into days, hours, minutes, and seconds
                $averageDays = floor($averageSeconds / 86400);
                $averageSeconds %= 86400;
                $averageHours = floor($averageSeconds / 3600);
                $averageSeconds %= 3600;
                $averageMinutes = floor($averageSeconds / 60);
                $averageSeconds %= 60;

// Store the average facilitation time
                $averagesByBranch[$branch][$concern] = [
                    'days' => $averageDays,
                    'hours' => $averageHours,
                    'minutes' => $averageMinutes,
                    'seconds' => $averageSeconds
                ];
                
            }
            
        }

// Pass the data to the view
        return view('posts.resolved', compact('averagesByBranch'));
    }

}