<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\Winner;

class WinnersController extends Controller
{
    public function winners(){

        $winnersList = Winner::with(['winuser','winproduct','WinnerBidwon'])->get();

        if(!$winnersList->isEmpty())
        {
            $response = [
                'status' => 1,
                'message' => 'All Winners data Feteched Successfully',
                'data' => $winnersList,
            ];
                return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Winners Data Not Found',
                'data' => (object) array(),
            ];
                return response()->json($response);
        }
    }
}
