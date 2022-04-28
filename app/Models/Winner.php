<?php

namespace App\Models;
use Auth;

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
        return $this->hasone(UserShippingAddress::class,'user_id','user_id')->where('auction_id',$this->product_id);
    }

    public function WinnerBid(){
        return $this->hasMany(AuctionBidUsed::class,'user_id','user_id');
    }

    public function winuser(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function winproduct(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function WinnerBidwon(){
        return $this->hasOne(AuctionBidUsed::class,'user_id','user_id');
    }


}
