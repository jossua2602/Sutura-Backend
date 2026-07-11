<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AdminRegistrationController;

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

// Route para i-update ang status (Approve/Reject)
Route::put('/admin/registrations/{shop_id}/status', [AdminRegistrationController::class, 'updateStatus']);