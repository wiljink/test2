<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    //
    public function create()
    {
        $response = Http::get('https://loantracker.oicapp.com/api/branches');

        
        return view('posts.create', [
            'branches' => $response->json()
        ]
    );
    }
    public function store(Request $request)
    {

        //dd($request);
        //dd($request->all()); 

        $data = $request->validate([
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

        $data['date']=now();

        //save data to database using model
        $newPost = Post::create($data);
        //redirect to index page
         return redirect(route('posts.index'));


    }
    public function index()
    {
        $posts = Post::paginate(90);

        $response = Http::get('https://loantracker.oicapp.com/api/branches');

        return view('posts.index', ['data' => $posts,'branches' => $response->json()]);

    }
}
