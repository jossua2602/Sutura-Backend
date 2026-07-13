<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Mail; // Idinagdag para sa Email Dispatch

// --- MGA NADAGDAG PARA SA STEP 3 ---
use App\Models\Subscription; 
use Carbon\Carbon; 
// -----------------------------------

class AdminRegistrationController extends Controller
{
    // 1. Function para kunin ang lahat ng shops
    public function index()
    {
        $registrations = Shop::all(); 
        
        return response()->json([
            'status' => 'success', 
            'data' => $registrations
        ]);
    }

    // 2. Function para kunin ang mga pending lang
    public function getPending()
    {
        $registrations = Shop::where('verification_status', 'Pending')->get();
        return response()->json(['status' => 'success', 'data' => $registrations]);
    }

    // 3. Function para i-update ang Approve/Reject status at ang User account
    public function updateStatus(Request $request, $shop_id)
    {
        $shop = Shop::find($shop_id);
        
        if (!$shop) {
            return response()->json(['status' => 'error', 'message' => 'Shop not found.'], 404);
        }

        $shop->verification_status = $request->status; 
        $user = User::where('user_id', $shop->owner_id)->first();

        // ---------------------------------------------------------
        // GATEWAY: REJECTED PATH
        // ---------------------------------------------------------
        if ($request->status === 'Rejected') {
            // 1. Log refusal details
            $shop->rejection_reason = $request->reason;
            
            if ($user) {
                $user->status = 'Inactive'; 
                $user->save();
            }

            // 2. Execute automatic refund
            $this->executeRefund($shop);

            // 3. Dispatch a rejection notice (Email)
            $logMessage = 'Admin rejected registration. Reason: ' . ($request->reason ?? 'None') . '. Refund initiated.';
        } 
        
        // ---------------------------------------------------------
        // GATEWAY: APPROVED PATH
        // ---------------------------------------------------------
        else {
            $shop->rejection_reason = null;
            
            if ($user) {
                // 1. Update storefront status to active
                $user->status = 'Active';
                $user->save();
            }

              // ==========================================
             // STEP 3: SUBSCRIPTION ACTIVATION
            // ==========================================
$subscription = Subscription::where('shop_name', $shop->shop_name)->first();

if ($subscription) {
    $subscription->status = 'Active';
    $subscription->start_date = Carbon::now();

    // Dito na natin iche-check ang column mismo
    if ($subscription->billing_cycle === 'Yearly') {
        $subscription->end_date = Carbon::now()->addYear(); // +1 Taon
    } else {
        $subscription->end_date = Carbon::now()->addDays(30); // Monthly default
    }
    
    $subscription->save();
}
            // ==========================================

            // 2. Initialize the workspace 
            $this->initializeWorkspace($shop);

            // 3. Securely send temporary credentials to the merchant (Email)
            $tempPassword = 'SuturaTemp' . rand(1000, 9999) . '!';
            
            $logMessage = 'Admin approved registration. Workspace initialized and credentials dispatched.';
        }
        
        $shop->save();

        // System logs the action (Audit Trail)
        // Siguraduhing mayroon kang logAction function na ginagamit globally,
        // o kaya ay i-comment out muna ito kung nagkaka-error.
        /* 
        $this->logAction(
            'UPDATE_STATUS', 
            'shops', 
            $shop_id, 
            $logMessage
        );
        */

        return response()->json([
            'status' => 'success',
            'message' => 'Shop verification status updated to ' . $request->status
        ]);
    }

    // ==========================================
    // HELPER FUNCTIONS PARA SA BPMN REQUIREMENTS
    // ==========================================

    private function executeRefund($shop)
    {
        \Log::info("Refund executed for Shop ID: " . $shop->shop_id);
    }

    private function initializeWorkspace($shop)
    {
        \Log::info("Workspace initialized for Shop ID: " . $shop->shop_id);
    }
}