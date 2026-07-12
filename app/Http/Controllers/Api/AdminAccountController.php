<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    // Kukunin ang lahat ng accounts para sa Admin Dashboard
    public function index()
    {
        $accounts = User::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $accounts
        ]);
    }

    // Mag-save ng bagong account mula sa frontend
    public function store(Request $request)
    {
        // 1. I-validate kung tama ang ipinasang data
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        // 2. I-save sa database at i-encrypt (bcrypt) ang password agad para secure
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // 3. Mag-send ng success response
        return response()->json([
            'status' => 'success',
            'message' => 'New user account successfully created!',
            'data' => $user
        ]);
    }

    // Mag-update ng account details mula sa frontend
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        // I-validate ang data. Dapat i-ignore ang sarili niyang ID sa unique checking.
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user_id . ',user_id',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id . ',user_id',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        // I-update ang mga fields
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        // Kung nag-input ng bagong password, i-update din natin
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Account updated successfully!',
            'data' => $user
        ]);
    }

    // Baguhin ang status ng account (Active / Suspended)
    public function updateStatus(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        $user->status = $request->status;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Account status has been updated to ' . $request->status . '!'
        ]);
    }
}