<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;

use App\Models\UserSetting;

class UserSettingController extends Controller
{
    public function updateUserSetting(Request $request)
    {
            $user = Auth::user();
	        $userId = $user->id;
            
            $userSetting = UserSetting::with('user')->where('user_id',$userId)->first();
            
            if(!empty($userSetting))
            {
                $data = [
                    'push_notification' => $request->notification,
                    'alerts' => $request->alerts,
                    'user_profile_visibility' => $request->profile_visibility,
                ];

                $setting = $userSetting->update($data);

                $respoonse = [
                    'status' => 1,
                    'message' => 'User Setting Updated Successfully',
                    'method' => $request->route()->getActionMethod(),
                    'data' => $data,
                ];
                return response()->json($respoonse);
            }
            else
            {
                $respoonse = [
                    'status' => 0,
                    'message' => 'User Setting not Exist',
                    'method' => $request->route()->getActionMethod(),
                    'data' => (object) array(),
                ];
                return response()->json($respoonse);
            }
    }
}
