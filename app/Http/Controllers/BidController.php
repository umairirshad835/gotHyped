<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;

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

    public function bidList(){
        $bidList = Bid::paginate(25);
            return view('Admin.Bid.index',compact('bidList'));
    }

    public function addBid(){
        return view ('Admin.Bid.add-bid');
    }

    public function saveBid(Request $request){

        $request->validate([
            'name' => 'required|max:50',
            'code' => 'required|max:10',
            'bids' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'number_of_bids' => $request->bids,
            'price' => $request->price,
            'type' => $request->type,
        ];

        $bid = Bid::create($data);

        if($bid){
            return redirect()->route('bidList')->with('success','Bid Save Successfully');
        }
    }

    public function editBid($id){

        $edit_bid = Bid::find($id);
            return view('Admin.Bid.update-bid',compact('edit_bid'));
    }

    public function updateBid(Request $request){

        $request->validate([
            'name' => 'required|max:50',
            'code' => 'required|max:10',
            'bids' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);

        $bid_id = $request->bid_edit;
        $bid_name = $request->name;
        $bid_code = strtoupper($request->code);
        $number_of_bids = $request->bids;
        $bid_price = $request->price;
        $bid_type = $request->type;

        $find_bid = Bid::find($bid_id);

        $data = [
            'name' => $bid_name,
            'code' => $bid_code,
            'number_of_bids' => $number_of_bids,
            'price' => $bid_price,
            'type' => $bid_type,
        ];

        $find_bid->update($data);
            return redirect()->route('bidList')->with('success','Bid Updated Successfully');
    }

    public function changeBidStatus(Request $request, $id){

        $updateStatus = Bid::find($id);
        $status = [
            'status' => $request->status,
        ];
        
        $updateStatus->update($status);
        
            return redirect()->route('bidList')->with('success','Size Status change Successfully');
    }

    public function payWithpaypal($request)
    {
        // dd($request['price']);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('bids purchase') /** item name **/
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($request['price']); /** unit price **/

        $item_list = new ItemList();
                $item_list->setItems(array($item_1));

        $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($request['price']);

        $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::route('getstatus')) /** Specify return URL **/
                    ->setCancelUrl(URL::route('getstatus'));

        $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                //     dd($redirect_urls);
                /** dd($payment->create($this->_api_context));exit; **/
                try {
        $payment->create($this->_api_context);
        }catch (\PayPal\Exception\PPConnectionException $ex){
                if (\Config::get('app.debug')) 
                {
                \Session::put('error', 'Connection timeout');
                                return Redirect::route('getstatus');
                }
                else 
                {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                                return Redirect::route('getstatus');
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
        \Session::put('error', 'Unknown error occurred');
                return Redirect::route('status');
    }

    public function getPaymentStatus(Request $request)
    {
                /** Get the payment ID before session clear **/
                $payment_id = $request->paymentId;

        /** clear the session payment ID **/
                 Session::forget('paypal_payment_id');
                if (empty($request->PayerID) || empty($request->token)) {
        \Session::put('error', 'Payment failed');
                    return Redirect::route('showStatus');
        }
        
        $payment = Payment::get($payment_id, $this->_api_context);
                $execution = new PaymentExecution();
                $execution->setPayerId($request->PayerID);
        /**Execute the payment **/
                $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
        \Session::put('success', 'Payment success');
                    return Redirect::route('showStatus');
        }
        \Session::put('error', 'Payment failed');
                return Redirect::route('showStatus');
    }

    public function ABC(Request $request){
        //  dd($request->all());
        return $this->payWithpaypal($request->all());
    }

    
}
