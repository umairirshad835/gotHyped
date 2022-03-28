<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;

class BidController extends Controller
{
    public function bidList(){
        $bidList = Bid::paginate(25);
            return view('Admin.Bid.index',compact('bidList'));
    }

    public function addBid(){
        return view ('Admin.Bid.add-bid');
    }

    public function saveBid(Request $request){

        $request->validate([
            'name' => 'required|max:50',
            'code' => 'required|max:10',
            'bids' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'number_of_bids' => $request->bids,
            'price' => $request->price,
            'type' => $request->type,
        ];

        $bid = Bid::create($data);

        if($bid){
            return redirect()->route('bidList')->with('success','Bid Save Successfully');
        }
    }

    public function editBid($id){

        $edit_bid = Bid::find($id);
            return view('Admin.Bid.update-bid',compact('edit_bid'));
    }

    public function updateBid(Request $request){

        $request->validate([
            'name' => 'required|max:50',
            'code' => 'required|max:10',
            'bids' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);

        $bid_id = $request->bid_edit;
        $bid_name = $request->name;
        $bid_code = strtoupper($request->code);
        $number_of_bids = $request->bids;
        $bid_price = $request->price;
        $bid_type = $request->type;

        $find_bid = Bid::find($bid_id);

        $data = [
            'name' => $bid_name,
            'code' => $bid_code,
            'number_of_bids' => $number_of_bids,
            'price' => $bid_price,
            'type' => $bid_type,
        ];

        $find_bid->update($data);
            return redirect()->route('bidList')->with('success','Bid Updated Successfully');
    }

    public function changeBidStatus(Request $request, $id){

        $updateStatus = Bid::find($id);
        $status = [
            'status' => $request->status,
        ];
        
        $updateStatus->update($status);
        
            return redirect()->route('bidList')->with('success','Size Status change Successfully');
    }
}
