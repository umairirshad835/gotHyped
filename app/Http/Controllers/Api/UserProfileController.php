<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

use App\Models\User;
use App\Models\UserBid;
use App\Models\Winner;
use App\Models\FavoriteItem;
use App\Models\AuctionBidUsed;
use App\Models\UserSetting;
use App\Models\UserProfileSetting;


class UserProfileController extends Controller
{
    public function profileView()
    {
        $user = Auth::user();
	    $userId = $user->id;
        
        if(!empty($userId))
        {
            $user = User::where('id',$userId)->first();
            $bids = UserBid::where('id',$userId)->select('total_bids')->first();
            $userAuctionWins = Winner::with('product.sizes.sizeName')->where('user_id',$userId)->get();
            $userLikeproducts = FavoriteItem::with('product.sizes.sizeName')->where('user_id',$userId)->get();
            $auction_played = AuctionBidUsed::where('user_id',$userId)->count();
            $auction_won = Winner::where('user_id',$userId)->count();

            $profile_data = [
                'user' =>  $user,
                'auction_played' => $auction_played,
                'auction_won' => $auction_won,
                'bids' =>  $bids,
                'Wins' =>  $userAuctionWins,
                'likes' => $userLikeproducts,
                
            ];
            
            $response = [
                'status' => 1,
                'message' => 'Login User data Found',
                'data' =>  $profile_data
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Login User Data Not Found',
                'data' =>  (object) array(),
            ];
        }
    }

    
 public function guestProfileView(Request $request){

    $user_request = $request->user_request_id;

    $userSetting = UserSetting::where('user_id',$user_request)->where('user_profile_visibility',1)->first();
    // dd($userSetting->id);

    if($userSetting)
    {
        $checkProfileSetting = UserProfileSetting::where('user_setting_id',$userSetting->id)->first();
        
        $auctionPlayed = 0;
        $auctionWon = 0;
        $wins = 0;
        $likes = 0;

        if($checkProfileSetting->auction_played == 1)
        {
            $auctionPlayed = AuctionBidUsed::where('user_id',$userSetting->user_id)->count();
        }
        else
        {
            $auctionPlayed = 0;
        }

        if($checkProfileSetting->auction_won == 1)
        {
            $auctionWon = Winner::where('user_id',$userSetting->user_id)->count();
        }
        else
        {
            $auctionWon = 0;
        }

        if($checkProfileSetting->items_won == 1)
        {
            $wins = Winner::with('product.sizes')->where('user_id',$userSetting->user_id)->get();
        }
        else
        {
            $wins = [];
        }
        
        if($checkProfileSetting->items_liked == 1)
        {
            $likes = FavoriteItem::with('product.sizes')->where('user_id',$userSetting->user_id)->get();
        }
        else
        {
            $likes = [];
        }

        $data = [
            'auction_played' => $auctionPlayed,
            'auction_won' => $auctionWon,
            'Wins' => $wins,
            'likes' => $likes,
        ];

        // dd($data);

        $response = [
            'status' => 1,
            'message' => 'Guest Profile Data Feteched Successfully',
            'data' => $data,
        ];
        return response()->json($response);
    }
    else
    {
        $response = [
            'status' => 0,
            'message' => 'User Does Not Allow to view his\her Profile',
            'data' => (object) array(),
        ];
        return response()->json($response);
    }
}
}
