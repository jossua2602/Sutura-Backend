<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription; // Nandito na ito!

class PublicRegistrationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Idagdag ang 'plan' sa validation para required itong sagutan sa frontend
        $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'shop_name' => 'required|string',
            'address' => 'required|string',
            'plan' => 'required|string', // <-- IDINAGDAG ITO
        ]);

        try {
            DB::beginTransaction();

            // Gumawa ng User account para sa Owner
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Shop Owner',
                'status' => 'Active', 
            ]);

            // I-register ang Shop at ikonekta sa User
            $shop = Shop::create([
                'owner_id' => $user->user_id, 
                'shop_name' => $request->shop_name,
                'address' => $request->address,
                'verification_status' => 'Pending', 
            ]);

            // ==========================================
            // STEP 2: DITO ILALAGAY ANG PENDING SUBSCRIPTION
            // ==========================================
            Subscription::create([
                'shop_name' => $shop->shop_name,
                'plan' => $request->plan,
                'billing_cycle' => $request->billing_cycle,
                'status' => 'Pending',
                'start_date' => null,
                'end_date' => null,
            ]);

            // I-save lahat sa database kapag walang nag-error
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Registration submitted successfully. Please wait for admin approval.'
            ]);

        } catch (\Exception $e) {
            // I-rollback o i-cancel lahat ng ginawa kung may nag-error
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }
}