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

    public function rechargeWallet(Request $request)
    {
        $rechargeblnce = $request->balance;
        $userId = Auth()->user()->id;

        if($rechargeblnce)
        {
            $url = "http://127.0.0.1:8000/recharge-wallet?balance=".$rechargeblnce."&userId=".$userId;
            
            $response = [
                'status' => 1,
                'message' => 'Recharge wallet with paypal and enter amount',
                'method' => $request->route()->getActionMethod(),
                'url' => $url,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Please enter amount to Recharge Wallet',
                'method' => $request->route()->getActionMethod(),
                'url' => '',
            ];
            return response()->json($response);
        }
        
    }
}
