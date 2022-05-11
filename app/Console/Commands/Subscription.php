<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;
use Carbon\Carbon;
use DB;

use App\Models\Subscriber;
use App\Models\UserWallet;
use App\Models\Bid;
use App\Models\BidPurchased;
use App\Models\UserBid;

class Subscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    {   
        $subscribers = Subscriber::get();
        // Log::info($subscribers);
        foreach($subscribers as $subscriber)
        {
            // check User Wallet
            $check_wallet = UserWallet::where('user_id',$subscriber->user_id)->first();
            //  Log::info($check_wallet);

            $check_subscription_bid = Bid::where('id',$subscriber->pkg_id)->first();
            //   Log::info($check_subscription_bid);

            if($check_subscription_bid->price <= $check_wallet->wallet_amount)
            {
                $update_user_wallet = $check_wallet->wallet_amount - $check_subscription_bid->price;
                $wallet_amount = $check_wallet->update(['wallet_amount'=> $update_user_wallet]);

                $purchase_data = [
                    'user_id' => $check_wallet->user_id,
                    'purchase_bids' => $check_subscription_bid->number_of_bids,
                    'purchase_price' => $check_subscription_bid->price,
                    'status' => 1,
                    'payment_status' => 1,
                ];
                // dd($purchase_data);
                $bid_purchase = BidPurchased::create($purchase_data);

                $total_bids = UserBid::where('user_id',$bid_purchase->user_id)->orderBy('id','DESC')->first();
                $total_bid_sum = 0;
                if(!empty($total_bids->total_bids))
                {
                    $total_bid_sum = $total_bids->total_bids;
                }

                $bids_Sum = $bid_purchase->purchase_bids + $total_bid_sum;

                $update_user_bid = [
                    'user_id' => $bid_purchase->user_id,
                    'total_bids' => $bids_Sum,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                
                $total_bids = UserBid::updateOrInsert(['user_id' =>$bid_purchase->user_id], $update_user_bid);
                Log::info('Your Monthly Package Subscribed Successfully');
            }
            else
            {
                Log::info('Please Recharge Your Wallet, You have Insufficient Balance in you Wallet to Purchase Subscription');
            }
        }
    }
}
