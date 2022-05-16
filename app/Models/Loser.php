<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loser extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'user_id',
        'lost_bids',
    ];

    public function ProductLost(){
        return $this->hasMany(Product::class,'id','auction_id');
    }

    public function auctionLoser(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function bidsLost(){
        return $this->hasMany(AuctionBidUsed::class,'user_id','user_id');
    }
}
