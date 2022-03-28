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
    ];
}
