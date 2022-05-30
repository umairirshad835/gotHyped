<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

use App\Models\UserProfileSetting;
use App\Models\UserSetting;

class UserProfileSettingController extends Controller
{
    public function profileSetting()
    {
        $user = Auth::user();
	    $userId = $user->id;

        $setting = UserSetting::where('user_id',$userId)->first();
        $profileSetting = UserProfileSetting::select('name','auction_played','auction_won','items_liked','items_won')->where('user_setting_id',$setting->id)->first();

        if($profileSetting)
        {
            $respoonse = [
                'status' => 1,
                'message' => 'User Profile Setting Get Successfully',
                'user-setting' => $setting,
                'user-profile-setting' => $profileSetting,
            ];
            return response()->json($respoonse);
        }
        else
        {
            $respoonse = [
                'status' => 0,
                'message' => 'User Profile Not Found',
                'user-setting' => (object) array(),
                'user-profile-setting' => (object) array(),
            ];
            return response()->json($respoonse);
        }
    }
}
