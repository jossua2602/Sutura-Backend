<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-connection', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'SUTURA Backend is connected successfully!'
    ]);
});