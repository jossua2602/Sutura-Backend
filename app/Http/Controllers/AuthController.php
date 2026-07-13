<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Subukang i-authenticate
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // HARANG: I-check kung Active ba ang account
            if ($user->status === 'Inactive') {
                Auth::logout(); // I-force logout agad
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account is inactive because your shop registration was rejected. Please contact the administrator.'
                ], 403); // 403 Forbidden
            }

            // Kung Active, ituloy ang paggawa ng token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'access_token' => $token,
                'user' => $user
            ]);
        }

        // Kung mali ang password o email
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ], 401);
    }
}