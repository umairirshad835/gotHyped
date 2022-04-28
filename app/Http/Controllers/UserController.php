<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Winner;
use App\Models\UserBid;
use App\Models\BidPurchased;
use App\Models\AuctionBidUsed;
use App\Models\Loser;
use DB;

class UserController extends Controller
{
    public function userList()
    {
        $userList = User::where('roles','customer')->paginate(25);

            return view('Admin.user.index',compact('userList'));
    }

    public function userdetail($id)
    {
        $user = User::find($id);

        $user_bids = UserBid::where('user_id',$id)->first();

        $purchased_bids = BidPurchased::where('user_id',$id)->get();

        $bid_history = AuctionBidUsed::with('product')->where('user_id',$id)->get();

        $winner_auctions = Winner::with(['winproduct','shippingAddress.size'])->where('user_id',$id)->get();

        // $winner_auctions = DB::table('winners')
        //     ->leftJoin('products', 'winners.product_id', '=', 'products.id')
        //     ->leftJoin('user_shipping_addresses', 'winners.user_id', '=', 'user_shipping_addresses.user_id')
        //     ->leftJoin('auction_bid_useds', 'winners.user_id', '=', 'auction_bid_useds.user_id')
        //     ->select('products.name','products.image1','auction_bid_useds.bid_used','winners.id')
        //     ->where('winners.user_id',$id)
        //     ->get();
        //  dd($winner_auctions);

        $auction_won = AuctionBidUsed::where('user_id',$id)->whereIn('auction_id',$winner_auctions)->get();

        $auction_lost = Loser::with('ProductLost')->where('user_id',$id)->get();

        return view('Admin.user.user_detail',compact('user','user_bids','purchased_bids','bid_history','auction_won','auction_lost','winner_auctions'));
    }

    public function winnerList()
    {
        $winnerList = Winner::with(['user','product','WinnerBid'])->paginate(25);
        //  dd($winnerList);

            return view('Admin.user.winnerList',compact('winnerList'));
    }
}
