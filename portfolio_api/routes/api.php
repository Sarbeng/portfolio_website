<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Register a user into the application
Route::post('register',[UserController::class,'create']);

// this is where we handle all our crud applications
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('blog', BlogController::class);

   
});

// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::resource('blog', BlogController::class);
// });


// authentication routes
Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');


     // get user data
     Route::get('user_data',[UserController::class,'show']);
     //updating user data
     Route::post('update_user_data',[UserController::class,'update']);
     Route::get('delete_user',[UserController::class,'delete']);
     //logging out of application
    // Route::get('logout',[UserController::class,'logout']);

    

});


// all posts routes go here
Route::group(['middleware' => ['api'],'namespace' => 'App\Http\Controllers', 'prefix' => 'posts'], function($router) {
    Route::get('/all', 'PostController@index');
    Route::post('/create-post', 'PostController@store');
    Route::post('/update_post/{post_id}','PostController@update');
    // 
    Route::delete('/delete_posts/{id}','PostController@destroy');
    Route::get('/individual_post/{id}','PostController@individual_posts');
});


// youtube routes go here
Route::group(['middleware' => ['api'],'namespace' => 'App\Http\Controllers', 'prefix' => 'videos'], function($router) {
    Route::resource('youtube', YoutubeFilesController::class);
    Route::post('youtube/{id}','YoutubeFilesController@update');
});

// photoshop routes go here
Route::group(['middleware' => ['api'],'namespace' => 'App\Http\Controllers', 'prefix' => 'files'], function($router) {
    Route::resource('photoshop', PhotoshopFilesController::class);
    Route::post('photoshop/{id}','PhotoshopFilesController@update');
});