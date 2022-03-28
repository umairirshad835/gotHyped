<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_setting_id',
        'name',
        'auction_played',
        'auction_won',
        'items_liked',
        'items_won',
    ];

    public function userSetting(){
        return $this->hasMany(UserSetting::class,'id','user_setting_id');
    }
}
