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
        'bid used',
    ];

    public function users(){
        return $this->hasMany(User::class,'id','user_id');
    }
}
