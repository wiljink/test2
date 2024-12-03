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

          // If the post is endorsed (first time), set the endorsed_date
          if (!$post->endorsed_date) {
            $post->endorsed_date = Carbon::now();  // Set current date and time
        }
        // Update the post status and resolved date
        $post->status = 'Resolved';
        $tasks = $request->input('tasks', []);
        //set the resolved date
        $post->resolved_date = Carbon::now()->format('Y-m-d H:i:s');  // Set current date and time in 'Y-m-d H:i:s' format
        $post->tasks = json_encode($request->input('tasks'));

        // Calculate the difference in days
        $resolvedDate = Carbon::parse($post->resolved_date);
        $endorsedDate = Carbon::parse($post->endorsed_date);
        $resolvedDays = $resolvedDate->diffInDays($endorsedDate);  // Get difference in days

        // Save the resolved_days as JSON (you can store additional info if needed)
        $post->resolved_days = json_encode([
            'days_resolved' => $resolvedDays,
            'resolved_date' => $post->resolved_date,
        ]);

        // Save the post to the database
        $post->save();

    
        return redirect()->route('posts.index')->with('success', '<span style="color: red;">Concern Successfully Resolved</span>');
     
    }

}
