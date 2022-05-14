<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Mail;
use PDF;

use App\Models\Winner;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\AssignProductSize;
use App\Models\User;
use App\Models\AuctionStart;
use App\Models\AuctionBidUsed;
use App\Models\Loser;
use App\Models\UserShippingAddress;

class AuctionCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auctioncompleted:cron';

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
        $get_completed_auctions = Winner::where('email_status',0)->get();

        foreach($get_completed_auctions as $completed)
        {
            $product = Product::with('sizes')->where('id',$completed->product_id)->first();
            $sizes_id = AssignProductSize::where('product_id',$product->id)->where('status',1)->pluck('size_id');
            $sizenames = ProductSize::whereIn('id',$sizes_id)->get();
            $customer = User::where('id',$completed->user_id)->first();
            $auction = AuctionStart::where('auction_id',$completed->product_id)->first();
            $winner_bids = AuctionBidUsed::where('user_id',$customer->id)->first();
            $losers = Loser::with('auctionLoser')->where('auction_id',$completed->product_id)->get();
            $shipping_Address = UserShippingAddress::with('address')->where('auction_id',$product->id)->first();

            $real_bids = AuctionBidUsed::whereHas('users', function($query){
                $query->where('roles','=', 'customer');
            })
            ->where('auction_id',$product->id)->sum('bid_used');

            $dummy_bids = AuctionBidUsed::whereHas('users', function($query){
                $query->where('roles','=', 'bot');
            })
            ->where('auction_id',$product->id)->sum('bid_used');
        
            $pdf = PDF::loadView('emails/auction-completed', compact('product','completed','sizenames','customer','auction','losers','winner_bids','shipping_Address','real_bids','dummy_bids'));
                // Log::info($product);

            $portalAdmins = User::where('roles','admin')->get();

            foreach($portalAdmins as $admin)
            {
                $mail = new PHPMailer(true);
                $mail->IsSMTP();  
                $mail->SMTPAuth = true;    
                $mail->SMTPSecure = "ssl";
                $mail->Host = "mail.gothyped.com";
                $mail->Port = 465;
                $mail->Username = "info@gothyped.com"; 
                $mail->Password = "Glen@420!";
    
                $mail->setfrom("info@gothyped.com", 'Got Hyped Auction Completed');
                $mail->addStringAttachment($pdf->output(), 'auction.pdf');
                $mail->IsHTML(true);
                $mail->Subject = "Auction Completed";
                $mail->Body    = 'You are getting this email';
                $mail->AddAddress($admin->email);
                if ($mail->Send())
                {
                    $update_email_status = Winner::where('product_id',$product->id)->first();
                    $update_email_status->update(['email_status'=> 1]);
                }
                else
                {
                    Log::info('Unable to send email. Error: ' . $mail->errorInfo);
                }
            }
        }
    }
}
