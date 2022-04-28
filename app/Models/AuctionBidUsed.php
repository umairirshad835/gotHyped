<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBidUsed extends Model
{
    use HasFactory;

    protected $fillale = [
        'auction_id',
        'user_id',
        'bid_used',
    ];

    public function users(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function product(){
        return $this->hasMany(Product::class,'id','auction_id');
    }

    public function winner(){
        return $this->belongsTo(Winner::class,'user_id','user_id');
    }

    public function auctionStart(){
        return $this->hasMany(AuctionStart::class,'auction_id','auction_id');
    }
}
