<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'push_notification',
        'alerts',
        'user_profile_visibility',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userProfileSetting(){
        return $this->belongsTo(UserProfileSetting::class,'user_setting_id','id');
    }
}
