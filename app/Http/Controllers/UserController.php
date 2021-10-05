<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required|',
            'password'=>'required|',//password_confirmation (the name of input for password confermation)
        ]);

        $validatedData['password'] = bcrypt($request->password);


        $user = User::create($validatedData);


        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);

    }


    //Login existing user
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

                if(!auth()->attempt($loginData)) {
          return abort(404);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;


                return response(['user' => auth()->user(), 'access_token' => $accessToken]);



    }

    //Follow a user
    public function followUser($id)
    {
        $user = User::find($id);
        if(!$user) {
            return response(['message' => 'Error', 'Error Message' => 'User does not exist.']);
        }

        $user->followers()->attach(auth()->user()->id);
        return response(['message' => 'Success', 'content' => "${auth()->user()->name} successfully followed $user->name"]);
    }

    //Unfollow a user
    public function UnfollowUser($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response(['message' => 'Error', 'Error Message' => 'User does not exist.']);
        }
        $user->followers()->detach(auth()->user()->id);
        return response(['message' => 'Success']);
    }

    //Fetch all the followers
    public function getFollowers($id)
    {
        $user = User::find($id);

        if(!$user)
        {
            return response(['message' => 'Error', 'Error Message' => 'User does not exist.']);
        }

        $followers = $user->followers;

        return response(['message' => 'Success', 'followers' => $followers]);
    }

    //Fetch all following
    public function getFollowing($id)
    {
        $user = User::find($id);

        if(!$user)
        {
            return response(['message' => 'Error', 'Error Message' => 'User does not exist.']);
        }

        $following = $user->following;

        return response(['message' => 'Success', 'following' => $following]);
    }
}
