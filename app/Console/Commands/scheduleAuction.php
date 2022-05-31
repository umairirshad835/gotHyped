<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


use App\Models\Product;

class scheduleAuction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:schedule';

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
        $current_time = Carbon::now();
        
        $products = Product::where('auction_time','==', $current_time)->where('auction_status', 0)->get();
        // Log::info($products);
        foreach($products as $product)
        {
            $product->update(['auction_status' => 1]);
            $product->save();
        }
        // Log::info($product);
    }
}
