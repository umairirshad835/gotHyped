<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Bid;
use App\Models\BidPurchased;
use App\Models\UserBid;
use App\Models\Subscriber;

class BidController extends Controller
{
    public function bidPurchased(Request $request)
    {
        $userId = Auth()->user()->id;
        $bidId = $request->bid_id;
        
        $find_bid = Bid::where('id',$bidId)->first();
        $url = "http://127.0.0.1:8000//paypal-payment?price=".$find_bid->price."&bids=".$find_bid->number_of_bids."&pkgId=".$bidId;

        if($find_bid)
        {
            $response = [
                'status' => 1,
                'message' => 'Complete Your payment first',
                'method' => $request->route()->getActionMethod(),
                'url' => $url,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'please select Bids to purchase',
                'method' => $request->route()->getActionMethod(),
                'url' => '',
            ];
            return response()->json($response);
        }
    }

    public function subscriptionPurchased(Request $request)
    {
        $userId = Auth()->user()->id;
        $pkgId = $request->pkg_id;
        
        $find_package = Bid::where('id',$pkgId)->first();

        $url = "http://127.0.0.1:8000/paypal-payment?price=".$find_package->price."&bids=".$find_package->number_of_bids."&pkgId=".$pkgId;

        if($find_package)
        {
            $response = [
                'status' => 1,
                'message' => 'Complete Your payment first',
                'method' => $request->route()->getActionMethod(),
                'url' => $url,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Package not found',
                'method' => $request->route()->getActionMethod(),
                'url' => '',
            ];
            return response()->json($response);
        }

    }
    
    public function subscription()
    {
        $subscriptionList = Bid::where('type','subscription')->where('status',1)->get();

        if(!$subscriptionList->isEmpty())
        {
            $response = [
                'status' => 1,
                'message' => 'You have Following Subscription Packages.',
                'data' => $subscriptionList,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Subscription Packages Not Found.',
                'data' => (object) array(),
            ];
            return response()->json($response);
        }
    }

    public function nonSubscription()
    {
        $nonSubscriptionList = Bid::where('type','non-Subscription')->where('status',1)->get();

        if(!$nonSubscriptionList->isEmpty())
        {
            $response = [
                'status' => 1,
                'message' => 'Non-Subscription list data',
                'data' => $nonSubscriptionList,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Data Not found',
                'data' => (object) array(),
            ];
            return response()->json($response);
        }
    }
}
