<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhotoshopFiles;

class PhotoshopFilesController extends Controller
{
    //display all files
    public function index () {
        $photoshop = PhotoshopFiles::findorFail();

        return $photoshop;
    }
     // show individual files
     public function show ($id) {
        // get file by id
        $photoshop = PhotoshopFiles::find($id);

        return $photoshop;
     }
 
     // create or store files
     public function store (Request $request) {
        // validate form inputs
        $fields = $request->validate([
            'file_name' => 'required|string',
            'description' => 'string',
            'file_location' => 'required|string'
        ]);

        // adding entry to database
        $photoshop_files = PhotoshopFiles::create($request->all());

        // assigning response
        $response = [
            'message' => 'Photoshop file created successfully',
            'photoshop' => $photoshop_files
        ];

        return response($response,200);
     }
 
     // updating files
     public function update (Request $request, $id) {

        // getting photo
        $photoshop = PhotoshopFiles::find($id);

        $photoshop->update($request->all());

        $response = [
            'message' => 'Photoshop files updated',
            'update' => $photoshop
        ];

        return response($response,200);
 
     }
 
     // delete files
     public function delete ($id) {
        // find file
        $photoshop = PhotoshopFiles::findorFail($id);

        //delete file
        $photoshop->delete();

        // assigning response 
        $response  = [
            'message' => 'Photoshop file deleted successfully',
            'photoshop_files' => $photoshop
        ];

        return response($response,200);
     }
}
