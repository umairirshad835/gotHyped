<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Bid;
use App\Models\BidPurchased;
use App\Models\UserBid;
use App\Models\Subscriber;
use App\Models\UserWallet;

class BidController extends Controller
{
    public function bidPurchased(Request $request)
    {
        $userId = Auth()->user()->id;
        $bidId = $request->bid_id;
        $option = $request->option;

        $find_bid = Bid::where('id',$bidId)->first();
        // dd($find_bid);

        if($option == 1)
        {
            $user_wallet = UserWallet::where('user_id',$userId)->first();

            if($find_bid->price <= $user_wallet->wallet_amount)
            {
                $update_user_wallet = $user_wallet->wallet_amount - $find_bid->price;
                $wallet_amount = $user_wallet->update(['wallet_amount'=> $update_user_wallet]);

                $purchase_data = [
                    'user_id' => $userId,
                    'purchase_bids' => $find_bid->number_of_bids,
                    'purchase_price' => $find_bid->price,
                    'status' => 1,
                    'payment_status' => 1,
                ];

                $bid_purchase = BidPurchased::create($purchase_data);

                $total_bids = UserBid::where('user_id',$bid_purchase->user_id)->orderBy('id','DESC')->first();
                $total_bid_sum = 0;
                if(!empty($total_bids->total_bids))
                {
                    $total_bid_sum = $total_bids->total_bids;
                }
           
                $bids_Sum = $bid_purchase->purchase_bids + $total_bid_sum;

                $update_user_bid = [
                    'user_id' => $userId,
                    'total_bids' => $bids_Sum,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            
                $total_bids = UserBid::updateOrInsert(['user_id' => $userId], $update_user_bid); 
                $response = [
                    'status' => 1,
                    'message' => 'Bid Purchased Successfully',
                    'method' => $request->route()->getActionMethod(),
                    'data' =>  $purchase_data,
                ];
                return response()->json($response);
            }
            else
            {
                $response = [
                    'status' => 0,
                    'message' => 'Purchased Failed! You have not sufficient Balance in your Wallet, PayWith PayPal or Recharge Your Wallet',
                    'method' => $request->route()->getActionMethod(),
                    'data' => (object) array(),
                ];
                return response()->json($response);
            }
            
        }
        elseif($option == 2)
        {
            $url = "http://127.0.0.1:8000/paypal-payment?price=".$find_bid->price."&bids=".$find_bid->number_of_bids."&pkgId=".$bidId."&userId=".$userId;

            if($find_bid)
            {
                $response = [
                    'status' => 1,
                    'message' => 'Complete Your payment with PayPal',
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
    }

    public function subscriptionPurchased(Request $request)
    {
        $userId = Auth()->user()->id;
        $pkgId = $request->pkg_id;
        $option = $request->option;

        $data = [
            'user_id' => $userId,
            'pkg_id' => $pkgId,
            'status' => 1,
        ];
        $purchaseSubscription = Subscriber::create($data);

        $find_pkg = Bid::where('id',$pkgId)->first();
        
        if($option == 1)
        {
            $user_wallet = UserWallet::where('user_id',$userId)->first();

            if($find_pkg->price <= $user_wallet->wallet_amount)
            {
                $update_user_wallet = $user_wallet->wallet_amount - $find_pkg->price;
                $wallet_amount = $user_wallet->update(['wallet_amount'=> $update_user_wallet]);

                $purchase_data = [
                    'user_id' => $userId,
                    'purchase_bids' => $find_pkg->number_of_bids,
                    'purchase_price' => $find_pkg->price,
                    'status' => 1,
                    'payment_status' => 1,
                ];

                $bid_purchase = BidPurchased::create($purchase_data);

                $total_bids = UserBid::where('user_id',$bid_purchase->user_id)->orderBy('id','DESC')->first();
                $total_bid_sum = 0;
                if(!empty($total_bids->total_bids))
                {
                    $total_bid_sum = $total_bids->total_bids;
                }
           
                $bids_Sum = $bid_purchase->purchase_bids + $total_bid_sum;

                $update_user_bid = [
                    'user_id' => $userId,
                    'total_bids' => $bids_Sum,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            
                $total_bids = UserBid::updateOrInsert(['user_id' => $userId], $update_user_bid); 
                $response = [
                    'status' => 1,
                    'message' => 'Bid Purchased Successfully',
                    'method' => $request->route()->getActionMethod(),
                    'data' =>  $purchase_data,
                ];
                return response()->json($response);
            }
            else
            {
                $response = [
                    'status' => 0,
                    'message' => 'Purchased Failed! You have not sufficient Balance in your Wallet, PayWith PayPal or Recharge Your Wallet',
                    'method' => $request->route()->getActionMethod(),
                    'data' => (object) array(),
                ];
                return response()->json($response);
            }
            
        }
        if($option == 2)
        {
            $url = "http://127.0.0.1:8000/paypal-payment?price=".$find_pkg->price."&bids=".$find_pkg->number_of_bids."&pkgId=".$pkgId."&userId=".$userId;

            if($find_pkg)
            {
                $response = [
                    'status' => 1,
                    'message' => 'Complete Your payment With PayPal',
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
