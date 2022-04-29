<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidPurchased extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'purchase_bids',
        'purchase_price',
        'status',
        'payment_status',
    ];

}
