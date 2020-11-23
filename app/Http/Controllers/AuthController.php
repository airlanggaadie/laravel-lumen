<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create new user
     * 
     * @param Illuminate\Http\Request $request
     * @return json data users
     */
    public function register(Request $request)
    {
        $data = $request->only(['name','email','password']);
        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = '';
        $user = User::create($data);

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Register success!',
                'data' => $user,
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Register failed!',
                'data' => '',
            ], 400);
        }
    }

    /**
     * user login to get token
     * 
     * @param Illuminate\Http\Request $request
     * @return json data api token
     */
    public function login(Request $request)
    {
        $data = $request->only(['email','password']);
        
        $user = User::where('email',$data['email'])->first();
        
        if ($user && Hash::check($data['password'], $user->password)) {
            $token = base64_encode(Str::random(40));
            $user->update(['api_token' => $token]);

            return response()->json([
                'status' => true,
                'message' => 'Login success!',
                'data' => ['user' => $user, 'token' => $token],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Login failed!',
                'data' => '',
            ]);
        }
    }
}
