<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'status',
    ];

    public function product(){
        return $this->hasMany(Product::class,'id','product_id');
    }

    public function userSetting(){
        return $this->hasMany(UserSetting::class,'user_id','user_id');
    }

    public function user(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function notifyProduct(){
        return $this->belongsTo(Product::class,'id','product_id');
    }
}
