<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;
use Carbon\Carbon;
use App\Helpers\BotUser;
use DB;


use App\Models\AuctionBidUsed;
use App\Models\AuctionStart;
use App\Models\Product;
use App\Models\UserWallet;
use App\Models\Winner;
use App\Models\UserBid;
use App\Models\Loser;
use App\Models\User;
use App\Models\AssignProductSize;

class ManageAuctionController extends Controller
{
    public function index()
    {
        return view('Auction.test');
    }

    public function manageAuction(Request $request)
    {
        try
        {
            DB::enableQueryLog();

            $userId ='';
            if(Auth::check())
            {
                $userId = Auth::user()->id;
            }

            $auctionId = $request->auction_id;
            $assume_price = 0.00;
            $flag = $request->flag;
            
            $check_auction = AuctionStart::where('auction_id',$auctionId)->first();
            $check_product = Product::where('id', $auctionId)->where('auction_status',1)->first();
            
            // check Price in Auction start
            if(!empty($check_auction))
            {
                $auction_price_now = $check_auction->current_price;
            }
            else
            {
                $auction_price_now = $assume_price;
            }

            // calculate time from auction start if not exist then get time from product
            $updateTime = isset($check_auction->updated_at) ? $check_auction->updated_at :$check_product->updated_at;
            $crtime = Carbon::now();
            $timecalc = $crtime->diff($updateTime);
            $timeDiff = $timecalc->s;

            if($auction_price_now >= $check_product->auction_price)
            {
                if($flag == 0)
                {   
                    if($timeDiff >= 5 && $flag == 0)
                    {
                        $winner_data = [
                            'user_id' => $check_auction->last_user_id,
                            'product_id' => $auctionId,
                            'total_bids' => $check_auction->current_bid_used,
                            'auction_close_price' => $check_auction->current_price,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
            
                        $winner = Winner::create($winner_data);

                        if($winner)
                        {
                            $returnBids = AuctionBidUsed::where('auction_id',$auctionId)->where('user_id',$check_auction->last_user_id)->first();
                        }

                        // get all losers data except winner
                        $winner_id = Winner::where('product_id',$auctionId)->first();
                        $losers = AuctionBidUsed::where('auction_id', $auctionId)->where('user_id', '!=', $winner_id->user_id)->get();

                        foreach($losers as $loser)
                        {
                            $data = new Loser;
                            $data->auction_id = $loser->auction_id;
                            $data->user_id = $loser->user_id;
                            $data->lost_bids = $loser->bid_used;
                            $data->save();
                        }

                        $win_data = [
                            'winner' => $winner,
                            'loser' => $losers,
                            'bids_returned' => $addBids,
                        ];

                        return redirect()->back()->with($win_data);
                    }
                }
                else
                {
                    if($timeDiff >= 5 && !empty($check_auction) && $flag == 1)
                    {
                        $botCount = DB::table('auction_bid_useds')
                        ->join('users', 'auction_bid_useds.user_id','=','users.id')
                        ->where('users.roles','bot')
                        ->where('auction_bid_useds.auction_id',$auctionId)
                        ->get();

                        if(count($botCount) < 2)
                        {
                            $bot = $this->botUser();
                            $userId = $bot->id;
                            $this->auctionUser($auctionId,$userId);
                        }
                        else
                        {
                            $botCount = DB::table('auction_bid_useds')
                            ->join('users', 'auction_bid_useds.user_id','=','users.id')
                            ->where('users.roles','bot')
                            ->where('auction_bid_useds.auction_id',$auctionId)
                            ->first();
                            
                            if($check_auction->last_user_id == $botCount->user_id)
                            {
                                $botCount = DB::table('auction_bid_useds')
                                ->join('users', 'auction_bid_useds.user_id','=','users.id')
                                ->where('users.roles','bot')
                                ->where('auction_bid_useds.auction_id',$auctionId)
                                ->OrderBy('auction_bid_useds.id','DESC')
                                ->first();

                                $userId = $botCount->user_id;
                                $this->auctionUser($auctionId,$userId);
                            }
                            else
                            {
                                $botCount = DB::table('auction_bid_useds')
                                ->join('users', 'auction_bid_useds.user_id','=','users.id')
                                ->where('users.roles','bot')
                                ->where('auction_bid_useds.auction_id',$auctionId)
                                ->first();

                                $userId = $botCount->user_id;
                                $this->auctionUser($auctionId,$userId);
                            }
                        }
                    }
                    elseif($timeDiff >= 5 && empty($check_auction) && $flag == 1)
                    {
                        $botCount = DB::table('auction_bid_useds')
                        ->join('users', 'auction_bid_useds.user_id','=','users.id')
                        ->where('users.roles','bot')
                        ->where('auction_bid_useds.auction_id',$auctionId)
                        ->get();

                        if(count($botCount) < 2)
                        {
                            $bot = $this->botUser();
                            $userId = $bot->id;
                            $auctionId = $check_product->id;
                            $this->auctionUser($auctionId,$userId);
                        }
                        else
                        {
                            $botCount = DB::table('auction_bid_useds')
                            ->join('users', 'auction_bid_useds.user_id','=','users.id')
                            ->where('users.roles','bot')
                            ->where('auction_bid_useds.auction_id',$auctionId)
                            ->first();

                            $userId = $botCount->user_id;
                            $this->auctionUser($auctionId,$userId);
                        }
                    }
                }
            }
            else
            {
                if($timeDiff >= 5 && !empty($check_auction) && $flag == 1)
                {   
                    $botCount = DB::table('auction_bid_useds')
                    ->join('users', 'auction_bid_useds.user_id','=','users.id')
                    ->where('users.roles','bot')
                    ->where('auction_bid_useds.auction_id',$auctionId)
                    ->get();

                    if(count($botCount) < 2)
                    {
                        $bot = $this->botUser();
                        $userId = $bot->id;
                        $this->auctionUser($auctionId,$userId);
                    }
                    else
                    {
                        $botCount = DB::table('auction_bid_useds')
                        ->join('users', 'auction_bid_useds.user_id','=','users.id')
                        ->where('users.roles','bot')
                        ->where('auction_bid_useds.auction_id',$auctionId)
                        ->first();

                        if($check_auction->last_user_id == $botCount->user_id)
                        {
                            // dd($botCount->user_id);
                            $botCount = DB::table('auction_bid_useds')
                            ->join('users', 'auction_bid_useds.user_id','=','users.id')
                            ->where('users.roles','bot')
                            ->where('auction_bid_useds.auction_id',$auctionId)
                            ->OrderBy('auction_bid_useds.id','DESC')
                            ->first();

                            $userId = $botCount->user_id;
                            $this->auctionUser($auctionId,$userId);
                        }
                        else
                        {
                            $botCount = DB::table('auction_bid_useds')
                            ->join('users', 'auction_bid_useds.user_id','=','users.id')
                            ->where('users.roles','bot')
                            ->where('auction_bid_useds.auction_id',$auctionId)
                            ->first();

                            $userId = $botCount->user_id;
                            $this->auctionUser($auctionId,$userId);
                        }
                    }
                    
                }
                elseif($timeDiff >= 5 && empty($check_auction) && $flag == 1)
                {
                    $botCount = DB::table('auction_bid_useds')
                    ->join('users', 'auction_bid_useds.user_id','=','users.id')
                    ->where('users.roles','bot')
                    ->where('auction_bid_useds.auction_id',$auctionId)
                    ->get();

                    if(count($botCount) < 2)
                    {
                        $bot = $this->botUser();
                        $userId = $bot->id;
                        $auctionId = $check_product->id;
                        $this->auctionUser($auctionId,$userId);
                    }
                    else
                    {
                        $botCount = DB::table('auction_bid_useds')
                        ->join('users', 'auction_bid_useds.user_id','=','users.id')
                        ->where('users.roles','bot')
                        ->where('auction_bid_useds.auction_id',$auctionId)
                        ->first();

                        $userId = $botCount->user_id;
                        $this->auctionUser($auctionId,$userId);
                    }
                }
            }
        }
        catch(Exception $e)
        {
            ($e->getMessage());
        }

    }

    public function botUser()
    {
           $botUser = new User();

           $botUser->name = BotUser::BotName();
           $botUser->username = BotUser::BotUserName();
           $botUser->email = $botUser->username."@gothyped.com";
           $botUser->phone = '03007798998';
           $botUser->password =  bcrypt(12345);
           $botUser->roles  = 'bot';
           $botUser->status  = 1;

           $botUser->save();

            // dd($botUser);
            return $botUser;
    }

    public function auctionUser($auctionId,$userId)
    {
        $bidUsed = 0;
        $currentprice = 0.00;

        $find_auction = Product::where('id', $auctionId)->where('auction_status', 1)->first();
        
        if(!empty($find_auction))
        {
            $check_acution = AuctionBidUsed::where('auction_id',$auctionId)->where('user_id',$userId)->first();

            if(!empty($check_acution)){
                $bidUsed = $check_acution->bid_used;
            }

            $data = [
                'auction_id' => $auctionId,
                'user_id' => $userId,
                'bid_used' => ++$bidUsed,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $Bids = AuctionBidUsed::updateOrInsert(['auction_id' => $auctionId, 'user_id' => $userId], $data);

            $totalBids = AuctionBidUsed::where('auction_id',$auctionId)->sum('bid_used');
            $acution_start = AuctionStart::where('auction_id',$auctionId)->first();

            if(!empty($acution_start)){
                $currentauctionprice = $acution_start->current_price;
                $currentbidprice = $currentauctionprice+0.01;
            }
            else
            {
                $currentbidprice = $currentprice+0.01;
            }
        
            $auction_data = [
                'auction_id' => $auctionId,
                'last_user_id' => $userId,
                'current_bid_used' => $totalBids,
                'current_price' => $currentbidprice,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $auctionStart = AuctionStart::updateOrInsert(['auction_id' => $auctionId], $auction_data);

            return $data;
        }
    }

    public function auctionBidsCalculation($auctionId)
    {
        $auctionBidsUsed = AuctionStart::where('auction_id',$auctionId)->first();
    }
}
