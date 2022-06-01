<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionStart extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'current_bid_used',
        'currrent_price',
        'last_user_id',
    ];

    public function product(){
        return $this->hasMany(Product::class,'id','auction_id');
    }

    public function users(){
        return $this->belongsTo(User::class,'last_user_id','id');
    }

    public function auctionBidUsed(){
        return $this->hasMany(auctionBidUsed::class,'auction_id','auction_id');
    }
}
