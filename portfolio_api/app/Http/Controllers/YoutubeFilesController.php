<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoutubeFiles;

class YoutubeFilesController extends Controller
{
    //

     // show all
     public function index () {
        $youtube = YoutubeFiles::all();

        return $youtube;
     }
 
     // create user
     public function store () {
 
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
