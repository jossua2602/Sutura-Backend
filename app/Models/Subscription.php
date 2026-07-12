<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    // Itugma ang Primary Key
    protected $primaryKey = 'sub_id';

    protected $fillable = [
        'shop_name', // Kadalasan 'shop_id' ito na naka-join, pero gamitin muna natin ang name para mabilis i-test
        'plan',
        'start_date',
        'end_date',
        'status',
    ];
}