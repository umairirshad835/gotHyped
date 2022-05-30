<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationsController extends Controller
{
    public function notification()
    {
        $notifications = Notification::all();
        
        if(!empty($notifications)){
            $response = [
                'status' => 1,
                'message' => 'Data fetched Successfully.',
                'data' => $notifications,
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
