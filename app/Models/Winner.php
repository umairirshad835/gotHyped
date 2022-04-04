<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'total_bids',
        'auction_close_price',
        'market_value_status',
        'get_product_status',
    ];

    public function product(){
        return $this->hasMany(Product::class,'id','product_id');
    }

    public function userSetting(){
        return $this->hasOne(UserSetting::class,'user_id','user_id');
    }

    public function user(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function shippingAddress(){
        return $this->hasone(UserShippingAddress::class,'user_id','user_id');
    }
}
