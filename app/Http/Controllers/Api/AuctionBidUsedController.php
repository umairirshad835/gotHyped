<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;
use Carbon\Carbon;
use Faker\Factory;
use DB;
use App\Helpers\BotUser;

use App\Models\AuctionUserEntered;
use App\Models\AuctionBidUsed;
use App\Models\AuctionStart;
use App\Models\Product;
use App\Models\UserWallet;
use App\Models\Winner;
use App\Models\UserBid;
use App\Models\Loser;
use App\Models\AssignProductSize;
use App\Models\UserAddress;
use App\Models\UserShippingAddress;
use App\Models\User;

class AuctionBidUsedController extends Controller
{
    public function auctionBidding(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'auction_id' => 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Auction Bid Credentials Error',
                'error' => $error
            ];
            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;

        $assume_price = 0.00;
        $auctionId = $request->auction_id;

        $check_auction = AuctionStart::where('auction_id',$auctionId)->first();
        $check_product = Product::where('id', $auctionId)->where('auction_status',1)->first();

        if(!empty($check_auction))
        {
            $auction_price_now = $check_auction->current_price;
        }
        else
        {
            $auction_price_now = $assume_price;
        }

        // calculate time from auction start if not exist then get time from product
        // $updateTime = isset($check_auction->updated_at) ? $check_auction->updated_at :$check_product->updated_at;
        // $crtime = Carbon::now();
        // $timecalc = $crtime->diff($updateTime);
        // $timeDiff = $timecalc->s;

        // if($auction_price_now >= $check_product->auction_price)
        // {
        //     if($flag == 0)
        //     {   
        //         if($timeDiff >= 5 && $flag == 0)
        //         {
        //             $winner_data = [
        //                 'user_id' => $check_auction->last_user_id,
        //                 'product_id' => $auctionId,
        //                 'total_bids' => $check_auction->current_bid_used,
        //                 'auction_close_price' => $check_auction->current_price,
        //                 'created_at' => Carbon::now(),
        //                 'updated_at' => Carbon::now(),
        //             ];
        
        //             $winner = Winner::create($winner_data);

        //             // if($winner)
        //             // {
        //             //     $returnBids = AuctionBidUsed::where('auction_id',$auctionId)->where('user_id',$check_auction->last_user_id)->first();
    
        //             //     $addBids = UserBid::where('user_id',$check_auction->last_user_id)->increment('total_bids',$returnBids->bid_used);
        //             // }

        //             // Winner data
        //             // $winner_id = Winner::with('winuser')->where('product_id',$auctionId)->first();

        //             // get all losers data except winner
        //             // $losers = AuctionBidUsed::with('users')->where('auction_id', $auctionId)->where('user_id', '!=', $winner_id->user_id)->get();

        //             // foreach($losers as $loser)
        //             // {
        //             //     $data = new Loser;
        //             //     $data->auction_id = $loser->auction_id;
        //             //     $data->user_id = $loser->user_id;
        //             //     $data->lost_bids = $loser->bid_used;
        //             //     $data->save();
        //             // }

        //             // $response = [
        //             //     'status' => 2,
        //             //     'message' => 'Auction Win',
        //             //     'method' => $request->route()->getActionMethod(),
        //             //     // 'winner' => $winner_id,
        //             //     // 'loser' => $losers,
        //             //     // 'bids_returned' => $addBids,
        //             // ];
        //             // return response()->json($response);
        //         }
        //     }
        //     else
        //     {
        //         $data = $this->manageAuction($auctionId,$userId);
    
        //         $current_price = $data['current_price'];
        //         $winner = User::where('id',$data['last_user_id'])->first();

        //         if($data == 0)
        //         {
        //             $responses = [
        //                 'status' => 0,
        //                 'message' => 'Auction Not Found',
        //                 'method' => $request->route()->getActionMethod(),
        //                 'winner' =>$winner,
        //                 'current_price' => $current_price
        //             ];
        //                 return response()->json($responses);
        //         }

        //         $responses = [
        //             'status' => 1,
        //             'message' => 'Bid Successfully',
        //             'method' => $request->route()->getActionMethod(),
        //         ];
        //             return response()->json($responses);
        //     }
        // }
        // else
        // {
            $data = $this->manageAuction($auctionId,$userId);
            
            $current_price = $data['current_price'];
            $winner = User::where('id',$data['last_user_id'])->first();
            if($data == 0)
            {
                $responses = [
                    'status' => 0,
                    'message' => 'Auction Not Found',
                    'method' => $request->route()->getActionMethod(),
                    'current_price' => 0
                ];
                    return response()->json($responses);
            }
                $responses = [
                    'status' => 1,
                    'message' => 'Bid Successfully',
                    'method' => $request->route()->getActionMethod(),
                    'current_price' => $current_price
                ];
                    return response()->json($responses);
        // }
    }

    public function manageAuction($auctionId,$userId)
    {
        $bidUsed = 0;
        $currentprice = 0.00;

        $find_auction = Product::where('id', $auctionId)->where('auction_status', 1)->first();
        if(!empty($find_auction))
        {
            $check_acution = AuctionBidUsed::where('auction_id',$auctionId)->where('user_id',$userId)->first();
            if(!empty($check_acution))
            {
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

            // subtract bid from User bid wallet
            if($Bids)
            {
                $userTotalBid = UserBid::where('user_id',$userId)->decrement('total_bids',1);
            }

            $totalBids = AuctionBidUsed::where('auction_id',$auctionId)->sum('bid_used');

            $acution_start = AuctionStart::with('users')->where('auction_id',$auctionId)->first();
            // dd($acution_start);
            if(!empty($acution_start))
            {
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
            
            $auctionStart = AuctionStart::with('users')->updateOrInsert(['auction_id' => $auctionId], $auction_data);

            return $auction_data;
        }
        else
        {
            return 0;
        }
        
    }

    public function currentAuctionUsers(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'auction_id' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Choose an auction first',
                'error' => $error
            ];
            return response()->json($response);
        }

        $auctionId = $request->auction_id;
        

        $winner_user = AuctionStart::with('users')->where('auction_id',$auctionId)->first();

        if($winner_user)
        {
            $all_bidding_users = AuctionBidUsed::select('id','user_id','auction_id')
            ->whereHas('users', function($query) use($winner_user){
                $query->select('id','name')->where('user_id','!=', $winner_user['last_user_id']);
            })
            ->where('auction_id',$auctionId)->get();
    
            foreach($all_bidding_users as $key => $username)
            {
                $users_name = $username->users[0]->name;
            }

            $actual_winner = Winner::with('winuser')->where('product_id',$auctionId)->first();
            $actual_losers = Loser::with('auctionLoser')->where('auction_id',$auctionId)->get();

            if(!empty($actual_winner))
            {
                $userId = Auth::user()->id;
                $announce_winner = Winner::with('winuser')->where('user_id',$userId)->where('product_id',$auctionId)->first();
                $announce_losers = Loser::with('auctionLoser')->where('user_id',$userId)->where('auction_id',$auctionId)->get();
                $response = [
                    'status' => 2,
                    'message' => 'Winner Announced',
                    'method' => $request->route()->getActionMethod(),
                    'actual_winner' => $announce_winner,
                    'actual_losers' => $announce_losers,
                ];
                return response()->json($response);
            }

            $response = [
                'status' => 1,
                'message' => 'Auction All users',
                'method' => $request->route()->getActionMethod(),
                'winner' => $winner_user,
                'other_user' => $all_bidding_users,
            ];
                return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'This Auction have no users yet',
                'method' => $request->route()->getActionMethod(),
                'winner' => (object) array(),
                'other_user' => (object) array(),
            ];
                return response()->json($response);
        }
        
    }
    
    public function getMarketPrice($auctionId)
    {
        $error = '';
        if(empty($auctionId)){
            $error = 'Auction field is required.';

            $response = [
                'status' => 0,
                'message' => 'Get Price Credentials error',
                'error' => $error,
            ];
            return response()->json($response);
        }
        
        $find_auction = Product::where('id', $auctionId)->where('auction_status', 1)->first();

        if(!empty($find_auction))
        {
            $response = [
                'status' => 1,
                'message' => 'Customer Auction Find Successfully',
                'data' => $find_auction,
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Customer Auction Not Found',
                'data' => (object) array(),
            ];

            return response()->json($response);
        }
    }

    public function saveMarketPrice(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'auction_id' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Save Market Value Credentials error',
                'error' => $error
            ];
            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;

        $auctionId = $request->auction_id;

        $find_auction = Product::where('id', $auctionId)->where('auction_status', 1)->first();
        $find_wallet  = UserWallet::where('user_id',$userId)->first();
        
        if(empty($find_wallet))
        {
            $response = [
                'status' => 0,
                'message' => 'Customer Wallet Not Found',
                'method' => $request->route()->getActionMethod(),
                'data' => (object) array(),
            ];

            return response()->json($response);
        }

        $update_wallet = $find_auction->market_price + $find_wallet->wallet_amount;

        if($update_wallet)
        {
            $data = [
                'wallet_amount' => $update_wallet,
            ];

            $update_wallet = UserWallet::where('user_id',$userId)->update($data);

            $response = [
                'status' => 1,
                'message' => 'Customer Wallet Updated Successfully',
                'method' => $request->route()->getActionMethod(),
                'data' => $update_wallet,
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Customer Wallet Not Found',
                'method' => $request->route()->getActionMethod(),
                'data' => (object) array(),
            ];

            return response()->json($response);
        }
    }

    public function userAddress(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'auction_id' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Invalid Credentials',
                'error' => $error
            ];
            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;

        $auctionId = $request->auction_id;

        $sizes = AssignProductSize::with('sizeName')->where('product_id',$auctionId)->get();
        $address = UserAddress::where('user_id',$userId)->get();

        $data = [
            'sizes' => $sizes,
            'addresses' => $address,
        ];

        $response = [
            'status' => 1,
            'message' => 'You are getting GotHyped Auction',
            'method' => $request->route()->getActionMethod(),
            'data' => $data,
        ];

        return response()->json($response);
    }

    public function saveShippingData(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'auction_id' => 'required',
            'size_id' => 'required',
            'user_address' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Invalid Credentials for Shipping GotHyped Win Product',
                'error' => $error
            ];
            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;
        
        $auctionId = $request->auction_id;
        $sizeId = $request->size_id;
        $userAddress = $request->user_address;
        $userAddressId = $request->address_id;

        if($userAddressId)
        {
            $shippingAddress = UserAddress::where('id',$userAddressId)->first();
            if(!empty($shippingAddress)){
                $userAddressId = $shippingAddress->id;
            }
            else
            {
                $shippingAddress = new UserAddress();
                $shippingAddress->id = $userAddressId;
                $shippingAddress->address = $request->user_address;
                $shippingAddress->user_id = $userId;
                $shippingAddress->save();
    
                $userAddressId = $shippingAddress->id;
            }   
        }

        $data = [
            'user_id' => $userId,
            'size_id' => $sizeId,
            'address_id' => (string)$userAddressId,
            'auction_id' => $auctionId,
        ];

        $shipping_data = UserShippingAddress::create($data);

        if($shipping_data){
            $response = [
                'status' => 1,
                'message' => 'Congratulations You will receive GotHyped Product at your shipping address',
                'method' => $request->route()->getActionMethod(),
                'data' => $shipping_data,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Sorry Invalid Data for Shipping Product',
                'method' => $request->route()->getActionMethod(),
                'data' => (object) array(),
            ];
            return response()->json($response);
        }
        
    }

}
