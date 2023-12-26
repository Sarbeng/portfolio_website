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
     public function individual_posts ($id) {
        $post = Post::find($id);

        return $post;
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

       
        //validating fields
       $fields = $request->validate([
        'title' =>'required|string',
        'description' =>'required|string'
       ]);

       // gettin gpost id
       $post = Post::find($post_id);

        $post->update($request->all());

        $response = [
            'message' => 'User records updated',
            'update' => $post
        ];

        return response($response,201);
     }
 
     // delete
     public function destroy ($id) {
        // find post
        $post = Post::find($id);

        $post->delete();

        $response = [
            'message' => 'deleted successfully',
            'posts' => $post
        ];

        return response($response,200);
     }
}
