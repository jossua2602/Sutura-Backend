<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $primaryKey = 'subscription_id';
    
    protected $fillable = [
        'shop_name', 
        'plan',
        'billing_cycle',
        'start_date', 
        'end_date', 
        'status'
    ];
}