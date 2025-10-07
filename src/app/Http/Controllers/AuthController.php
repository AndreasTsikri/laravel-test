<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
	//implement a service to handle register + login!
    public function register(Request $request)
    {
        // Simple validation
        $data = $request->validate([
            'username' => 'required|string|unique:users,username'
            //'password' => 'required|string|min:6',
        ]);

	// Create the user
        $user = User::create([
            'username' => $data['username'],
	    'simpleBearerToken'=> Str::random(16)/*hash('sha256', Str::random(60))*/
            //'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
	    'username' => $user->username,
	    'bearer token' => $user->simpleBearerToken
	], 201);
    }
}

