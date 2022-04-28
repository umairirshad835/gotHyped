<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function auctions()
    {
        $user = Auth()->user()->username;
        $link = "https://dashboard.gothyped.com/".$user;

        $auctions = Product::with(['sizes.sizeName','favorite','alert'])->where('status',1)->whereIn('auction_status', [0,1])->get();
        foreach($auctions as $key => $item){
            $auctions[$key]['link'] = $link;
        }
        
        if(!empty($auctions))
        {
            $response = [
                'status' => 1,
                'message' => 'Data fetched Successfully.',
                'data' => $auctions,
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

}
