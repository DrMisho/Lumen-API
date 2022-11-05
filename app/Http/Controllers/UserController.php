<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response(\App\Models\User::all());
    }
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'name' => 'required|string',
            'password' => 'required',
        ]);
        $request['password'] = Hash::make($request['password']);
        $user = \App\Models\User::create($request->all());
        $user['api_token'] = token_name($user->id);
        $user->save();
        return response($user);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ]);


    }
}
