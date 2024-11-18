<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function create(){
        return view('posts.create');
    }
    public function store(Request $request){
            //dd($request);

        $data = $request->validate([
            'name' => 'required',
            'branch' => 'required|numeric',
            'contact_number' => 'required|regex:/^[0-9]+$/',
            'date' => 'nullable|date',
            'concern' => 'required',
            'message' => 'required|string'
        ]);

        //save data to database using model
        $newPost = Post::create($data);
        //redirect to index page
         return redirect(route('posts.index'));


    }

}
