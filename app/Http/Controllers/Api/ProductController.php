<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function auctions()
    {
        $auctions = Product::with('sizes.sizeName')->where('status',1)->get();
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
