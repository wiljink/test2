<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class PostController extends Controller
{
    //
    public function create()
    {
        $response = Http::get('https://loantracker.oicapp.com/api/branches');


        return view(
            'posts.create',
            [
                'branches' => $response->json()
            ]
        );
    }
    public function store(Request $request)
    {

        //dd($request);
        //dd($request->all()); 

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



        $data['date'] = now();
        // Find the post by ID
        $post = Post::findOrFail($data['post_id']); // Throws a 404 if not found
        dd($post);
        // Update only the endorse_by, endorse_to, and status fields
        $post->update([
            'endorse_by' => $data['endorse_by'],
            'endorse_to' => $data['endorse_to'],
            //'status' => $data['status'],
        ]);
        //redirect to index page
        return redirect(route('posts.index'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|integer',
            'endorse_to' => 'required|string',
            'endorse_by' => 'required|integer', // Authenticated user's ID
        ]);

        // Assuming you have a `Post` model and the `id` to be updated
        $post = Post::findOrFail($data['post_id']);
        $post->endorse_to = $data['endorse_to'];
        $post->endorse_by = $data['endorse_by']; // Store the user who prepared the endorsement
        $post->save();

        return redirect(route('posts.index'));
    }
    public function index()
    {
        $user = Auth::user();
        //dd(auth()->user()); // This will dump the current authenticated user, if any.

        $posts = Post::paginate(90);

        $response = Http::get('https://loantracker.oicapp.com/api/branches');


        return view('posts.index', ['data' => $posts, 'branches' => $response->json()]);
    }
}
