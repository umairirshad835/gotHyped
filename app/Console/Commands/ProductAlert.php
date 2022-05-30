<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Helpers\fireBaseNotification;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\NotifyAlert;
use App\Models\UserSetting;


class ProductAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productalert:cron';

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
    public function handle()
    {
        // get All users they have alerts active and device token from user table
       $notify_user = User::select('id','name','device_token')
       ->whereHas('userSetting',function($query){
            $query->select('id','user_id')->where('alerts',1);
       })->where('roles','customer')->whereNotNull('device_token')->get();
            //  Log::info($notify_user);

        foreach($notify_user as $user)
        {
            $alerts_product = NotifyAlert::where('user_id',$user->id)->pluck('product_id');
            $products = Product::whereIn('id',$alerts_product)->where('auction_status',1)->get();

            // Log::info($products);
            foreach($products as $product)
            {
                $crtime = Carbon::now();
                $timecalc = $crtime->diff($product->auction_time);
                $timeDiff = $timecalc->i;

                // Log::info("Check Time");
                // Log::info($timeDiff);

                if($timeDiff <= 60)
                {
                    $appNotification = [
                        "title" => 'GotHyped',
                        "body" => 'Get your bids ready because the auction for ' .$product->name. ' will start in 30 minutes.',
                        "device_token" => $user->device_token,
                    ];

                    // Log::info($user->name.' Device token');
                    // Log::info($user->device_token,);

                    // Log::info('User ' . $user->name . ' get alerts for product ' . $product->name . "<br>");
                                
                        fireBaseNotification::sendAppNotification($appNotification);
                }
            }
           
        }
    }
}
