<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Auth;

use App\Models\FavoriteItem;


class FavoriteItemController extends Controller
{
    public function addFavourite(Request $request)
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

        $favorite = [
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'status' => 1,
        ];

        if(!empty($favorite))
        {
            $favoriteItem = FavoriteItem::create($favorite);

            $response = [
                'status' => 1,
                'method' => $request->route()->getActionMethod(),
                'message' => 'Product Added to favourite Successfully',
                'data' =>   $favoriteItem,
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'method' => $request->route()->getActionMethod(),
                'message' => 'No favourite Product Choose',
                'data' => (object) array(),
            ];

            return response()->json($response);
        }
    }

    public function removeFavourite(Request $request)
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

        $del_fav = [
            'user_id' => $userId,
            'product_id' => $request->product_id,
        ];

        if(!empty($del_fav))
        {
            $delete_fav = FavoriteItem::where('user_id',$userId)->where('product_id',$request->product_id)->delete();

            $response = [
                'status' => 1,
                'method' => $request->route()->getActionMethod(),
                'message' => 'Product remove from favourite list Successfully',
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'method' => $request->route()->getActionMethod(),
                'message' => 'No favourite Product Choose',
            ];

            return response()->json($response);
        }
    }
}
