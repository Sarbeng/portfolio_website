<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\URL;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blogs = Blog::all();
        return response()->json([
            'status' => true,
            'blogs' => $blogs

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //data validation
        $data = $request->all();

        $validator = Validator::make($data,[
            'title' => 'required|max:150',
            'description' => 'required',
            'image' => [File::image()->max(2 * 1024)]

        ]);

        //$file = $request->file('image');

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $imageName = $image->hashName();
        $extension = $image->extension();
        $filename = uniqid() . '_' . $imageName;
        $image->move(public_path('public/images'),$filename);
        //Storage::disk('public')->putFileAs('images', $image, $filename);
        $url = URL::to('/') . '/public/images' . $filename;

        $formData = [
            'title' =>  $data['title'],
            'description' => $data['description'],
            'image' => $url
        ];

        $blog = Blog::create($formData);

        return response()->json([
            'status' => true,
            'message' => 'Blog Post created successfully',
            'blog' => $blog
        ], 200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
