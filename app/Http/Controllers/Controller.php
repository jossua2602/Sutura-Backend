<?php

namespace App\Http\Controllers;

use App\Models\Auditlog;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    /**
     * Global helper para sa pag-log ng admin actions.
     * Magagamit ito sa kahit anong controller na nag-e-extend dito.
     */
    protected function logAction(string $action, string $tableName, $recordId, ?string $details = null)
    {
        Auditlog::create([
            'user_id'    => Auth::id() ?? 1, // Gamitin ang ID ng naka-login na admin, default 1 kung wala
            'action'     => $action,
            'table_name' => $tableName,
            'record_id'  => $recordId,
            'details'    => $details,
        ]);
    }
}