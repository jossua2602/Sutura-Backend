<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    public function owner()
    {
        // Sinasabi nito na ang 'owner_id' sa shops table ay nakakonekta sa 'user_id' sa users table
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }
}