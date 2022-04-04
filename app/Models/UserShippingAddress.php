<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'size_id',
        'address_id',
        'auction_id',
    ];

    public function address(){
        return $this->belongsTo(UserAddress::class);
    }

    public function winner(){
        return $this->belongsTo(Winner::class,'user_id','user_id');
    }
}
