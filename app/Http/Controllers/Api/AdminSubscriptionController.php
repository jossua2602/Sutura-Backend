<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    // Kukunin ang lahat ng subscriptions para sa Admin Dashboard
    public function index()
    {
        // I-so-sort natin by end_date para mauna sa listahan ang mga malapit nang ma-expire
        $subscriptions = Subscription::orderBy('end_date', 'asc')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $subscriptions
        ]);
    }

    // I-update ang subscription details (Halimbawa: pag-renew o pag-change status)
    public function update(Request $request, $sub_id)
    {
        $subscription = Subscription::find($sub_id);

        if (!$subscription) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription not found.'
            ], 404);
        }

        $request->validate([
            'plan' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $subscription->plan = $request->plan;
        $subscription->start_date = $request->start_date;
        $subscription->end_date = $request->end_date;
        $subscription->status = $request->status;
        $subscription->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription successfully updated!',
            'data' => $subscription
        ]);
    }
}