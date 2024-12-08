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

        // Fetch branch managers from the external API
        $response1 = Http::get('https://loantracker.oicapp.com/api/v1/branches');
        $branches = $response1->json();

        $token = session('token');

        $response2 = Http::withToken($token)->get("https://loantracker.oicapp.com/api/v1/users/logged-user");
        $authenticatedUser = $response2->json();
        //updated code
        // Retrieve only the concerns that belong to the authenticated user
        $posts = Post::where('branch', $authenticatedUser['user']['branch_id'])->paginate(10);
        if ($authenticatedUser['user']['branch_id'] === 23) {
            $posts = Post::paginate(10);
        } if ($authenticatedUser['user']['branch_id'] === 23) {
    } else {
        $posts = Post::where('endorse_to', $authenticatedUser['user']['oid'])->paginate(10);
    }


        $data = Post::where('status', '!=', 'Resolved')->get();

        // Return the view with filtered data
        return view('posts.index', ['data' => $posts, 'branches' => $branches['branches'], 'authenticatedUser' => $authenticatedUser['user']]);

    }

    public function analyze(Request $request)
    {
        // Find the post by ID
        $post = Post::find($request->posts_id);

        // Check if the post exists
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found.'
            ]);
        }

        // Update tasks if provided
        if ($request->has('tasks')) {
            $post->tasks = json_encode($request->input('tasks'));
        }

        // Get the status from the request
        $status = $request->input('status');

        if ($status === 'In Progress') {
            // Set status to "In Progress"
            $post->status = 'In Progress';

            // Save the updated post
            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Progress saved successfully.'
            ]);
        } elseif ($status === 'Resolved') {
            // If the post is endorsed (first time), set the endorsed_date
            if (!$post->endorsed_date) {
                $post->endorsed_date = Carbon::now(); // Set the current date and time
            }

            // Set status to "Resolved"
            $post->status = 'Resolved';

            // Set the resolved_date
            $post->resolved_date = Carbon::now()->format('Y-m-d H:i:s'); // Current date and time in 'Y-m-d H:i:s' format

            // Calculate the difference in days between resolved_date and endorsed_date
            $resolvedDate = Carbon::parse($post->resolved_date);
            $endorsedDate = Carbon::parse($post->endorsed_date);
            $resolvedDays = $endorsedDate->diff($resolvedDate);

            // Save the resolved_days as JSON
            $post->resolved_days = json_encode([
                'Total' => $resolvedDays,
                'Days' => $resolvedDays->d,
                'Hours' => $resolvedDays->h,
                'Minutes' => $resolvedDays->i,
                'Seconds' => $resolvedDays->s,
            ]);

            // Save the post
            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Concern successfully resolved.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid status provided.',
        ]);
    }



    public function resolved()
    {
        // Retrieve all resolved posts
        $posts = Post::whereNotNull('resolved_days')->get();

        // Group posts by branch
        $groupedPosts = $posts->groupBy('branch');

        // Initialize an array to hold average resolution times for each branch and concern
        $averagesByBranch = [];

        // Loop through each branch
        foreach ($groupedPosts as $branch => $branchPosts) {
            // Group posts by concern within the branch
            $postsByConcern = $branchPosts->groupBy('concern');

            foreach ($postsByConcern as $concern => $concernPosts) {
                $totalSeconds = 0;
                $totalPosts = count($concernPosts);

                foreach ($concernPosts as $post) {
                    // Decode the resolved_days JSON
                    $resolvedTime = json_decode($post->resolved_days, true);

                    // Calculate the total time in seconds for this post
                    $totalSecondsForPost = ($resolvedTime['Days'] * 86400) +
                        ($resolvedTime['Hours'] * 3600) +
                        ($resolvedTime['Minutes'] * 60) +
                        $resolvedTime['Seconds'];

                    $totalSeconds += $totalSecondsForPost;
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

                // Store the average resolution time
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
