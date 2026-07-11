<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    // Kukunin ang LAHAT ng shop applications (Pending, Approved, Rejected)
    public function index()
    {
        // Kukunin natin lahat at i-so-sort mula sa pinakabago
        $shops = Shop::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $shops
        ]);
    }

    // Kukunin lahat ng Pending na aplikasyon
    public function getPending()
    {
        $pendingShops = Shop::where('verification_status', 'Pending')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $pendingShops
        ]);
    }
    
    // I-update ang status (Approve o Reject)
    public function updateStatus(Request $request, $shop_id)
    {
        $shop = Shop::find($shop_id);

        if (!$shop) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shop not found.'
            ], 404);
        }

        // I-save ang bagong status ('Approved' o 'Rejected')
        $shop->verification_status = $request->status;
        $shop->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Shop has been ' . $request->status . '!'
        ]);
    }
}