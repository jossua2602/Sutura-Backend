<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. I-validate ang input (siguraduhing may email at password na ipinasa)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. I-check ang credentials sa `users` table
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            // 3. Gumawa ng secure token gamit ang Sanctum
            $token = $user->createToken('sutura-admin-token')->plainTextToken;

            // 4. Ibalik ang success response kasama ang token
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        }

        // 5. Kung mali ang email o password
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password'
        ], 401);
    }
}