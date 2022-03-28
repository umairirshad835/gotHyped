<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionUserEntered extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'auction_id',
    ];

    public function user(){
        return $this->hasMany(User::class,'id','user_id');
    }
}
