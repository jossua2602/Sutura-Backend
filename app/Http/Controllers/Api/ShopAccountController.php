<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop; // Idinagdag ito
use App\Models\User; // Idinagdag ito

class ShopAccountController extends Controller
{
    // Kunin lahat ng rehistradong shops (Approved lang)
    public function index()
    {
        // Isinasama natin ang 'owner' (user) data para makuha ang email at status
        $shops = Shop::with('owner')->where('verification_status', 'Approved')->get();

        return response()->json([
            'status' => 'success',
            'data' => $shops
        ]);
    }

    // Pambago ng Active/Inactive status ng account
    public function toggleStatus(Request $request, $shop_id)
    {
        $shop = Shop::find($shop_id);
        
        if (!$shop) {
            return response()->json(['status' => 'error', 'message' => 'Shop not found.'], 404);
        }

        $user = User::where('user_id', $shop->owner_id)->first();

        if ($user) {
            // Kung Active, gawing Inactive. Kung Inactive, gawing Active.
            $user->status = ($user->status === 'Active') ? 'Inactive' : 'Active';
            $user->save();

            // I-record sa Audit Logs (Opsiyonal pero maganda para sa System Monitor and Analysis)
            // Kung may logAction function ka sa global scope, pwede mong tawagin dito.
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Account status updated successfully.',
            'new_status' => $user->status ?? 'Unknown'
        ]);
    }
}