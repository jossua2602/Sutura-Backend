<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AdminRegistrationController;
use App\Http\Controllers\Api\AdminAccountController;
use App\Http\Controllers\Api\AdminSubscriptionController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\PublicRegistrationController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\ShopAccountController;

Route::get('/test-connection', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'SUTURA Backend is connected successfully!'
    ]);
});

// Ito ang bagong route na tatawagin ng Next.js para sa login
Route::post('/login', [AuthController::class, 'login']);

// Route para kunin ang lahat ng registrations (para sa Tabs)
Route::get('/admin/registrations', [AdminRegistrationController::class, 'index']);

// Route para kunin ang pending shop registrations
Route::get('/admin/registrations/pending', [AdminRegistrationController::class, 'getPending']);

// Siguraduhing PUT ang gamit dito at hindi GET o POST
Route::put('/admin/registrations/{shop_id}/status', [AdminRegistrationController::class, 'updateStatus']);
// Route para sa Manage Accounts
Route::get('/admin/accounts', [AdminAccountController::class, 'index']);

// Route para mag-save ng bagong account
Route::post('/admin/accounts', [AdminAccountController::class, 'store']);

// Route para i-update ang status (Suspend/Activate)
Route::put('/admin/accounts/{user_id}/status', [AdminAccountController::class, 'updateStatus']);

// Route para mag-update ng account details
Route::put('/admin/accounts/{user_id}', [AdminAccountController::class, 'update']);

// Route para sa Monitor Subscriptions
Route::get('/admin/subscriptions', [AdminSubscriptionController::class, 'index']);

// Route para i-update ang subscription
Route::put('/admin/subscriptions/{sub_id}', [AdminSubscriptionController::class, 'update']);

// Route para sa Main Dashboard Stats
Route::get('/admin/dashboard-stats', [AdminDashboardController::class, 'getStats']);

Route::post('/register-shop', [PublicRegistrationController::class, 'store']);

// Idagdag ito:
Route::get('/admin/activity-logs', [ActivityLogController::class, 'index']);

Route::get('/admin/shop-accounts', [ShopAccountController::class, 'index']);
Route::put('/admin/shop-accounts/{id}/toggle-status', [ShopAccountController::class, 'toggleStatus']);
