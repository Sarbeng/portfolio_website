<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

             $token = $user->createToken('my-app-token')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

             return response($response, 201);
    }

    // showing current logged in user details from database
    public function show () {

        // getting user data from auth
        $user = Auth::user();

        return $user;        
    }

    // create user
    public function create (Request $request) {

        //validating the form fields
        $fields = $request->validate([
            'firstname' => 'required|string',
            'surname' => 'required|string',
            'middlename' => 'nullable|string',
            'phone' => 'nullable|string',
            'username' => 'unique:users|string',
            'email' => 'required|unique:users|email|confirmed',
            'password' => 'required|string|min:8|confirmed'
            

        ]);

        // storing or creating user data
        $user = User::create([
            'username' => $fields['username'],
            'firstname' => $fields['firstname'],
            'surname' => $fields['surname'],
            'middlename' => $fields['middlename'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        // creating user token for authentication
        $token = $user->createToken('myapptoken')->plainTextToken;

        //assigning response
        $response = [
            'user' => $user,
            'message'=>'user account created',
            'token' => $token
        ];
        //returning response
        return response ($response,201);


    }

    // updating the logged in users data
    public function update (Request $request) {
        // get the id of the current user
        $user_id = Auth::user()->id;

        //using the user id to update the user table

        // utilizing a try catch so i can handle any errors that do occur
        try {
            $update_user_data = User::where('id','=',$user_id)->update($request->all());

            $response = [
                'message' => 'User records updated',
                'update' => $update_user_data
            ];


        } catch (Exception $error) {

            $response = [
                'message' => 'User records updated',
                'error' => $error->getMessage()
            ];

           
        }
       

        return response($response,201);
    }

    // delete
    public function delete () {

        // delete the current user using the id
        // the token must also be detroyed
    }

    // logout
    public function logout () {
        // to logout destroy the token of the current logged in user.
        $logged_out = $this->guard()->user();

        return $logged_out;
    }
}
