<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

use App\Models\UserProfileSetting;
use App\Models\UserSetting;

class UserProfileSettingController extends Controller
{
    public function updateUserProfileSetting(Request $request){

        $user = Auth::user();
	    $userId = $user->id;
        
        $settingId = UserSetting::where('user_id',$userId)->first();
        // dd($settingId->id);

        if($settingId->user_profile_visibility == 1)
        {
            $profileSetting = UserProfileSetting::with('userSetting.user')->where('user_setting_id',$settingId->id)->first();
            
            $profileData = [
                'name' => $request->name,
                'auction_played' => $request->auctions_played,
                'auction_won' => $request->auctions_won,
                'items_liked' => $request->items_liked,
                'items_won' => $request->items_won,
            ];

            $setting = $profileSetting->update($profileData);
            
            $respoonse = [
                'status' => 1,
                'message' => 'User Profile Setting Updated Successfully',
                'method' => $request->route()->getActionMethod(),
                'data' => $profileData,
            ];
            return response()->json($respoonse);
        }
        else
        {
            $respoonse = [
                'status' => 0,
                'message' => 'please Make Sure that Profile visibility is on in Your Setting',
                'method' => $request->route()->getActionMethod(),
                'data' => (object) array(),
            ];
            return response()->json($respoonse);
        }
    }
}
