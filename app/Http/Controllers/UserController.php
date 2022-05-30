<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Winner;
use App\Models\UserBid;
use App\Models\BidPurchased;
use App\Models\AuctionBidUsed;
use App\Models\Loser;
use App\Models\UserWallet;
use DB;
use Carbon\Carbon;

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

class UserController extends Controller
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
        $winner_auctions = Winner::with(['winproduct','shippingAddressNew'])->where('user_id',$id)->get();
        $auction_lost = Loser::with('ProductLost')->where('user_id',$id)->get();
            return view('Admin.user.user_detail',compact('user','user_bids','purchased_bids','bid_history','auction_lost','winner_auctions'));
    }

    public function winnerList()
    {
        $winnerList = Winner::with(['user','product','WinnerBid'])->paginate(25);
        //  dd($winnerList);
            return view('Admin.user.winnerList',compact('winnerList'));
    }

    public function payWithpaypal($request)
    {
        //  dd($request->all());
        //   dd($request['userId']);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('Recharge Wallet') /** item name **/
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($request['balance']); /** recharge price is set here in request **/
                    // dd($item_1);

        $item_list = new ItemList();
                $item_list->setItems(array($item_1));
         
        $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($request['balance']);

        $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription($request['userId']); /** current Login UserId is set in description **/

        $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::route('rechargeStatus')) /** Specify return URL **/
                    ->setCancelUrl(URL::route('rechargeStatus'));

        $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                    // dd($redirect_urls);
                try {
        $payment->create($this->_api_context);
        }catch (\PayPal\Exception\PPConnectionException $ex){
                if (\Config::get('app.debug')) 
                {
                \Session::put('error', 'Connection timeout');
                    return Redirect::route('rechargeStatus');
                }
                else 
                {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                    return Redirect::route('rechargeStatus');
                }
        }
        foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                    break;
                }
        }
        /** add payment ID to session **/
                Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
        /** redirect to paypal **/
                    return Redirect::away($redirect_url);
        }
        // \Session::put('error', 'Unknown error occurred');
        //         return Redirect::route('status');
    }

    public function rechargePaymentStatus(Request $request)
    {
        $payment_id = $request->paymentId;

        /** clear the session payment ID **/
            Session::forget('paypal_payment_id');
        if (empty($request->PayerID) || empty($request->token)) {
        \Session::put('error', 'Payment failed');
            return Redirect::route('failedStatus');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
                $execution = new PaymentExecution();
                $execution->setPayerId($request->PayerID);
        /**Execute the payment **/
                $result = $payment->execute($execution, $this->_api_context);
                \Session::put('balance', 'Payment success');
                // dd($result);
                //  dd($result->transactions[0]->description);
        if ($result->getState() == 'approved') {
            $this->rechargeUserWallet($result->transactions[0]->amount->total,$result->transactions[0]->description);
        \Session::put('success', 'Payment success');
            return Redirect::route('showStatus');
        }
        \Session::put('error', 'Payment failed');
             return Redirect::route('failedStatus');
    }

    public function wallet(Request $request)
    {
        // dd($request['balance']);
       return  $check_payment = $this->payWithpaypal($request->all());
    }

    public function rechargeUserWallet($balance,$userId)
    {
        $add_balance = $balance;
        $find_customer_wallet = UserWallet::where('user_id',$userId)->first();
        $wallet_amount = 0;

        if(!empty($find_customer_wallet->wallet_amount))
        {
            $wallet_amount = $find_customer_wallet->wallet_amount;
        }

        $wallet_total_sum =  $wallet_amount + $add_balance;

        $update_customer_wallet = [
            'user_id' => $userId,
            'wallet_amount' => $wallet_total_sum,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
            return $check_wallet = UserWallet::updateOrInsert(['user_id' => $userId], $update_customer_wallet);
    }
}
