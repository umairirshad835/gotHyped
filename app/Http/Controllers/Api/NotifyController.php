<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;

use App\Models\NotifyAlert;

class NotifyController extends Controller
{
    public function notify(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'product_id' => 'required',
        ]);
        
        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'No Product Selected',
                'error' => $error
            ];

            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;
        
        $notify = [
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'status' => 1,
        ];

        if(!empty($notify))
        {
            $create_alert = NotifyAlert::create($notify);

            $response = [
                'status' => 1,
                'method' => $request->route()->getActionMethod(),
                'message' => 'Notification Generated Successfully',
                'data' =>   $create_alert,
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'method' => $request->route()->getActionMethod(),
                'message' => 'Notification Failed',
                'data' => (object) array(),
            ];

            return response()->json($response);
        }
    }


    public function denotify(Request $request)
    {
        $validator = Validator::make ($request->all(), [
            'product_id' => 'required',
        ]);
        
        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'No Product Selected',
                'error' => $error
            ];

            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;

        $denotify = [
            'user_id' => $userId,
            'product_id' => $request->product_id,
        ];

        if(!empty($denotify))
        {
            $delete_alert = NotifyAlert::where('user_id',$userId)->where('product_id',$request->product_id)->delete();

            $response = [
                'status' => 1,
                'method' => $request->route()->getActionMethod(),
                'message' => 'Notification Deleted Successfully',
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'method' => $request->route()->getActionMethod(),
                'message' => 'Failed to delete Notification',
            ];

            return response()->json($response);
        }
    }
}
