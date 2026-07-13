<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditlog extends Model
{
    protected $primaryKey = 'log_id';
    protected $table = 'audit_logs';
    protected $fillable = ['user_id', 'action', 'table_name', 'record_id', 'details'];

    // Define the relationship: An audit log belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
