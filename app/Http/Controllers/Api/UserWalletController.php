<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserWallet;
use Auth;

class UserWalletController extends Controller
{
    public function userWallet(){

        $user = Auth::user();
	    $userId = $user->id;

        $userwallet = UserWallet::with('user')->where('user_id',$userId)->first();

        if(!empty($userwallet))
        {
            $response = [
                'status' => 1,
                'message' => 'Availle Balance of '.$userwallet->user->name. ' is $'.$userwallet->wallet_amount,
                'data' =>  $userwallet,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Record Not Found',
                'data' =>  (object) array(),
            ];
            return response()->json($response);
        }
    }
}
