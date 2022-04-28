<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;

use App\Models\UserSetting;
use App\Models\UserProfileSetting;

class UserSettingController extends Controller
{
    public function updateUserSetting(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        
        $userSetting = UserSetting::with('user')->where('user_id',$userId)->first();
        
            $data = [
                'push_notification' => $request->notification,
                'alerts' => $request->alerts,
                'user_profile_visibility' => $request->profile_visibility,
            ];
            $setting = $userSetting->update($data);

            if($request->profile_visibility == 1)
            {
                $profileData = [
                    'name' => $request->name,
                    'auction_played' => $request->auctions_played,
                    'auction_won' => $request->auctions_won,
                    'items_liked' => $request->items_liked,
                    'items_won' => $request->items_won,
                ];

                $profileSetting = UserProfileSetting::with('userSetting.user')->where('user_setting_id',$userSetting->id)->update($profileData);
                $respoonse = [
                    'status' => 1,
                    'message' => 'User Setting Updated Successfully',
                    'method' => $request->route()->getActionMethod(),
                    'setting-data' => $data,
                    'profile-setting-data' => $profileData,
                ];
                return response()->json($respoonse);
            }
            else
            {
                $respoonse = [
                    'status' => 0,
                    'message' => 'please Make Sure that Profile visibility is on in Your Setting',
                    'method' => $request->route()->getActionMethod(),
                    'setting-data' => (object) array(),
                    'profile-setting-data' => (object) array(),
                ];
                return response()->json($respoonse);
            }
    }
}
