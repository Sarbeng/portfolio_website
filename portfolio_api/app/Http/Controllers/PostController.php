<?php

namespace App\Http\Controllers;
// importing the Posts model
use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //

     // get all posts
     public function index () {
        $posts = Post::all();

        return $posts;
     }

     //get individual posts
     public function individual_posts () {

     }
 
     // create user
     public function store (Request $request) {
        //validating the form fields
        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        // retrieve file
        $file = $request->file('file');

        //get file details
       // $filename = $file->getClientOriginalName();

        $imageName = time().'.'.$request->image->extension();  
     

        //moving file to folder
        // $file->move('uploads',$filename);
        $request->image->move(public_path('images'), $imageName);


        // storing user data
        $posts = Post::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'image_location' => '/public/images/'.$imageName
        ]);
     }
 
     // updating posts
     public function update (Request $request,$post_id) {

        // utilizing a try catch so i can handle any errors that do occur
        $post = Post::find($post_id);

       // $update_post = Post::where('id','=',$post->id)->update($request->all());

        //
        // $post->title = $request->input('title');
        // $post->description = $request->input('description');
        // $post->image_location = $request->input('image');

        // $post->update();

        $post->title = $request->input('title');
        $post->save();

        $response = [
            'message' => 'User records updated',
            'update' => $post
        ];

        return response($response,201);
     }
 
     // delete
     public function delete () {
 
     }
}
