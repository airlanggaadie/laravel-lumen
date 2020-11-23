<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show data user
     * 
     * @param integer $id for user id
     * @return json data user
     */
    public function show(int $id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'User found',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => ''
            ],400);
        }
        
    }
}
