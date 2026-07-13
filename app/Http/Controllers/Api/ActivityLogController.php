<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auditlog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Kukunin natin ang logs kasama ang info ng user na gumawa ng action
        // Naka-sort ito from latest to oldest
        $logs = Auditlog::with('user')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $logs
        ]);
    }
}