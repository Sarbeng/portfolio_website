<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    

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

        
        //assigning response
        $response = [
            'user' => $user,
            'message'=>'user account created',
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
                'message' => 'User records not updated',
                'error' => $error->getMessage()
            ];

           
        }
       

        return response($response,201);
    }

    // delete
    public function delete () {

        /**
         * delete the current user using the id
         *  */ 

        // get the id of the current user
        $user_id = Auth::user()->id;

        $find_user = User::find($user_id);
        $delete_user = $find_user->delete();


        // the token must also be detroyed
        //$this->guard()->logout();
        Auth::guard()->logout();

        // assigning response
        $response = [
            'message' => "user successfully deleted",
            'deleted_user' => $delete_user
        ];

        return response($response,200);
    }


}
