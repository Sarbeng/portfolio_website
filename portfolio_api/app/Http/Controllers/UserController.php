<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    // show user
    public function show () {
        
    }

    // create user
    public function create (Request $request) {

        //validating the form fields
        $fields = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'middlename' => 'string',
            'phone' => 'string',
            'username' => 'unique:users|string',
            'email' => 'required|unique:users|email|confirmed',
            'password' => 'required|password|min:8|confirmed'
            

        ]);

        // storing or creating user data
        $user = User::create([
            'username' => $fields['username'],
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
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

    // updating the user
    public function update () {

    }

    // delete
    public function delete () {

    }
}
