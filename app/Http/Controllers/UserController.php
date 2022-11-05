<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register','login', 'refresh', 'logout']]);
    }

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
        $token = Auth::attempt($request->only(['username', 'password']));
        $user['api_token'] = $token;
        $user->save();

        return response($token);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) {

            return response()->json(['message' => 'Unauthorized'], 401);
        }
        Auth::user()->api_token = $token;
        Auth::user()->save();

        return $this->respondWithToken($token);

    }
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ]);
    }
}
