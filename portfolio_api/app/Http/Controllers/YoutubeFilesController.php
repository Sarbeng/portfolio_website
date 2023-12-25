<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoutubeFiles;

class YoutubeFilesController extends Controller
{
    //

     // show all youtube files
     public function index () {
        $youtube = YoutubeFiles::all();

        return $youtube;
     }
 
     // create youtube file
     public function store (Request  $request) {

        //validate form inputs
        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'file_link' => 'required|string'
        ]);

        $youtube_posts = YoutubeFiles::create($request->all());

        $response = [
            'message'=> 'Youtube post successfully created',
            'youtube_post' => $youtube_posts
        ];

        return response($response,200);


 
     }
 
     // updating the user
     public function update () {
 
     }

     // create the user
     public function create () {
 
     }
 
     // delete
     public function destroy () {
 
     }
}
