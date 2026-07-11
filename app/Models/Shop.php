<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    // Sabihin sa Laravel na 'shop_id' ang Primary Key, hindi 'id'
    protected $primaryKey = 'shop_id';

    protected $fillable = [
        'owner_id',
        'shop_name',
        'address',
        'coordinates',
        'verification_status',
    ];
}