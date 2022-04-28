<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Bid;
use App\Models\BidPurchased;
use App\Models\UserBid;
use App\Models\Subscriber;

use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

class BidController extends Controller
{

    public function __construct()
    {
            /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function bidPurchased(Request $request)
    {
        $userId = Auth()->user()->id;
        $purchase_bids = $request->bids;
        $purchase_price = $request->price;
        
        $data = [
            'user_id' => $userId,
            'purchase_bids' => $purchase_bids,
            'purchase_price' => $purchase_price,
            'status' => 1,
        ];

        $purchasebid = BidPurchased::create($data);
      
        if(!empty($purchasebid))
        {
            $bid_purchase = BidPurchased::where('user_id',$purchasebid->user_id)->orderBy('id','DESC')->first();
            
            $total_bids = UserBid::where('user_id',$purchasebid->user_id)->orderBy('id','DESC')->first();
            
            $total_bid_sum = 0;

            if(!empty($total_bids->total_bids))
            {
                $total_bid_sum = $total_bids->total_bids;
            }
           
            $bids_Sum = $bid_purchase->purchase_bids + $total_bid_sum;

            $update_data = [
                'user_id' => $userId,
                'total_bids' => $bids_Sum,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $total_bids = UserBid::updateOrInsert(['user_id' => $userId], $update_data); 

            if($total_bids)
            {
                $response = [
                    'status' => 1,
                    'message' => 'Bids Purchase Successfully and your Bid Wallet is Updated',
                    'method' => $request->route()->getActionMethod(),
                    'data' => $data,
                ];
    
                return response()->json($response);
            }
            else
            {
                $response = [
                    'status' => 0,
                    'message' => 'Bids Not Purchased',
                    'method' => $request->route()->getActionMethod(),
                    'data' => (object) array(),
                ];
    
                return response()->json($response);
            }
        }
    }

    public function subscriptionPurchased(Request $request)
    {
        $userId = Auth()->user()->id;
        $pkgId = $request->pkg_id;
        
        $find_package = Bid::where('id',$pkgId)->first();

        if(!empty($find_package))
        {
            $data = [
                'user_id' => $userId,
                'pkg_id' => $pkgId,
                'status' => 1,
            ];
    
            $purchaseSubscription = Subscriber::create($data);

            $purchase_data = [
                'user_id' => $userId,
                'purchase_bids' => $find_package->number_of_bids,
                'purchase_price' => $find_package->price,
                'status' => 1,
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

            $url = "http://127.0.0.1:8000/paypal-payment?price=".$find_package->price."&bids=".$find_package->number_of_bids."&pkgId=".$pkgId;
            $response = [
                'status' => 1,
                'message' => 'Package Subscribed Successfully',
                'method' => $request->route()->getActionMethod(),
                'data' =>  $purchase_data,
                'url' => $url,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Package Not Subscribed Tray Again !',
                'method' => $request->route()->getActionMethod(),
                'data' => (object) array(),
                'url' => '',
            ];
            return response()->json($response);
        }

    }
    
    public function subscription()
    {
        $subscriptionList = Bid::where('type','subscription')->where('status',1)->get();

        if(!empty($subscriptionList))
        {
            $response = [
                'status' => 1,
                'message' => 'Data fetched Successfully.',
                'data' => $subscriptionList,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Data Not Found.',
                'data' => (object) array(),
            ];
            return response()->json($response);
        }
    }

    public function nonSubscription()
    {
        $nonSubscriptionList = Bid::where('type','non-Subscription')->where('status',1)->get();

        if(!empty($nonSubscriptionList))
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
