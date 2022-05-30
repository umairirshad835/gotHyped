<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\UserBid;

class UserBidController extends Controller
{
    public function userBid()
    {
        $user = Auth::user();
        $userId = $user->id;

        $userBids = UserBid::with('user')->where('user_id',$userId)->first();

        if(!empty($userBids))
        {
            $response = [
                'status' => 1,
                'message' => 'Availle Bids of '.$userBids->user->name. ' is '.$userBids->total_bids,
                'data' =>  $userBids,
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
