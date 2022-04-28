<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserBid;
use App\Models\Product;
use App\Models\AuctionBidUsed;
use App\Models\Winner;
use App\Models\BidPurchased;


class DashboardController extends Controller
{
    public function dashboard(){

        // count total Users of Application
        $totalUsers = User::where('roles','customer')->count();
        // count total Bots of Application
        $pending = Product::where('auction_status',0)->count();
        //Auction In Progress
        $inProgress = Product::where('auction_status',1)->count();
        //Auction In Progress
        $completed = Product::where('auction_status',2)->count();
        //Bids Used
        $bidUsed = AuctionBidUsed::select('id','user_id','auction_id','bid_used')
        ->whereHas(
            'users' , function($query){
                $query->select('id','roles')->where('roles','customer');
            }
        )->sum('bid_used');

        //Bids Purchased
        $bids_Sale = BidPurchased::sum('purchase_bids');

        // Items Delivered
        $itemsDelivered = Winner::select('id','user_id','product_id')->where('get_product_status',1)
        ->whereHas(
            'user' , function($query){
                $query->select('id','roles')->where('roles','customer');
            }
        )->count();

        // Market Price
        $marketvalue = Winner::select('id','user_id','product_id')->where('market_value_status',1)
        ->whereHas(
            'user' , function($query){
                $query->select('id','roles')->where('roles','customer');
            }
        )->count();

        $auction_pending = Product::with('category')->where('auction_status',0)->orderBy('auction_time','ASC')->paginate(25);

        $auction_completed = Product::with(['category','winner.user'])->where('auction_status',2)->paginate(25);
            //   dd($auction_completed );
        
        return view('Admin.dashboard.index',compact('totalUsers','pending','inProgress','completed','bidUsed','bids_Sale','itemsDelivered','marketvalue','auction_pending','auction_completed'));
    }

}
