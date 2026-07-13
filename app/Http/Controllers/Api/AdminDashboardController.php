<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function getStats()
    {
        try {
            // Bilangin ang Total Users
            $totalUsers = User::count();

            // Bilangin ang Shops base sa status
            $activeShops = Shop::where('verification_status', 'Approved')->count();
            $pendingShops = Shop::where('verification_status', 'Pending')->count();

            // Kung may job_orders table ka na, pwede itong i-uncomment in the future:
            // $totalRevenue = DB::table('payments')->sum('amount');

            return response()->json([
                'status' => 'success',
                'data' => [
                    'total_users' => $totalUsers,
                    'active_shops' => $activeShops,
                    'pending_shops' => $pendingShops,
                    'total_revenue' => 0 // Placeholder muna dahil wala pa tayong payments table
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}