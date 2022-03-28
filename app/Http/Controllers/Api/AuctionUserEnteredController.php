<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;

use App\Models\Product;
use App\Models\AuctionUserEntered;

class AuctionUserEnteredController extends Controller
{
    public function auctionUsers(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'auctionId' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Auction unsuccessfull',
                'error' => $error
            ];
            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;
        
        $auctionId = $request->auctionId;

        $data = [
            'user_id' => $userId,
            'auction_id' => $auctionId,
        ];

        $find_auction = Product::where('id', $auctionId)->where('auction_status', 1)->first();
        
        if(!empty($find_auction))
        {
            $auction_entered = AuctionUserEntered::create($data);
            $response = [
                'status' => 1,
                'message' => 'User Entered in Auction',
                'method' => $request->route()->getActionMethod(),
                'data' => $auction_entered,
            ];

            return response()->json($response);
        }else{
            $response = [
                'status' => 0,
                'message' => 'Auction Not Found',
                'method' => $request->route()->getActionMethod(),
                'data' => (object) array(),
            ];
            return response()->json($response);
        }
    }
}
