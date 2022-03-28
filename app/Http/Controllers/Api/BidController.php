<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bid;

class BidController extends Controller
{
    public function subscription()
    {
        $subscriptionList = Bid::where('type','subscription')->where('status',1)->get();

        if(!empty($subscriptionList))
        {
            $response = [
                'status' => 1,
                'message' => 'Data fetched Successfully.',
                'data' => $subscriptionList,
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

    public function nonSubscription(){

        $nonSubscriptionList = Bid::where('type','non-Subscription')->where('status',1)->get();

        if(!empty($nonSubscriptionList))
        {
            $response = [
                'status' => 1,
                'message' => 'Non-Subscription list data',
                'data' => $nonSubscriptionList,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Data Not found',
                'data' => (object) array(),
            ];
            return response()->json($response);
        }
    }
}
