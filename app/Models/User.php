<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'roles',
        'status',
        'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userBids(){
        return $this->hasMany(UserBid::class,'user_id','id');
    }

    public function userWallet(){
        return $this->hasMany(UserWallet::class,'user_id','id');
    }

    public function userSetting(){
        return $this->hasMany(UserSetting::class,'user_id','id');
    }

    public function auction(){
        return $this->hasMany(AuctionUserEntered::class,'user_id','id');
    }

    public function bidUsed(){
        return $this->belongsTo(AuctionBidUsed::class,'user_id','id');
    }

    public function winner(){
        return $this->belongsTo(Winner::class,'user_id','id');
    }
}
