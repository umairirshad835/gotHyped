<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\AssignProductSize;
use App\Models\CategorySize;
use App\Models\Winner;
use App\Models\User;
use App\Models\AuctionBidUsed;
use App\Models\AuctionStart;
use App\Models\Loser;
use App\Models\UserShippingAddress;
use PDF;


class ProductController extends Controller
{
    
    public function addProduct()
    {
        $all_category = Category::all();
            return view('Admin.product.add-product',compact('all_category'));
    }

    public function AssignSize($id)
    {
        $category_size = CategorySize::where('cat_id',$id)->pluck('size_id');
        $data['size'] = ProductSize::whereIn('id',$category_size)->get();
            return response()->json($data);
    }

    public function editSizes($id,$productId)
    {
        $category_size = CategorySize::where('cat_id',$id)->pluck('size_id');
        $data['size'] = ProductSize::whereIn('id',$category_size)->get();
        $data['productSize'] = AssignProductSize::where('product_id',$productId)->select('size_id','status')->get();
            return response()->json($data);
    }

    public function saveProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'category' => 'required',
            'actual_price' => 'required',
            'market_price' => 'required',
            'auction_price' => 'required',
            'auction_time' => 'required',
            'main_image' => 'required|mimes:jpg,jpeg,png',
            'imagetwo' => 'mimes:jpg,jpeg,png',
            'imagethree' => 'mimes:jpg,jpeg,png',
        ]);

        // get Images
        $mainimage = $request->file('main_image');
        $Image1 = $mainimage->getClientOriginalName();

        $imagetwo = $request->file('imagetwo');
        if(!empty($imagetwo)){
            $Image2 = $imagetwo->getClientOriginalName();
        }
            
        $imagethree = $request->file('imagethree');
        if(!empty($imagethree)){
            $Image3 = $imagethree->getClientOriginalName();
        }
            
        // make directory if not exists    
        $upload_dir = 'uploads/Product/';
        if(!is_dir($upload_dir)) 
            mkdir($upload_dir, 0755, true);
        
        // check if image2 and image3 exists to get path to store in DB
        $mainimage_path = str_replace(' ','_',$upload_dir.$Image1);

        if(!empty($Image2)){
            $imagetwo_path = str_replace(' ','_',$upload_dir.$Image2);
        }
           
        if(!empty($Image3)) {
            $imagethree_path = str_replace(' ','_',$upload_dir.$Image3);
        }  
        
        //move Images to directory
        $mainimage->move($upload_dir,str_replace(' ','_',$Image1));

        if(!empty($imagetwo)){
            $imagetwo->move($upload_dir,str_replace(' ','_',$Image2));
        }
        if(!empty($imagethree)){
            $imagethree->move($upload_dir,str_replace(' ','_',$Image3));
        }
        
        $data = [
            'name' => $request->name,
            'category_id' => $request->category,
            'actual_price' => $request->actual_price,
            'market_price' => $request->market_price,
            'auction_price' => $request->auction_price,
            'auction_time' => date('Y-m-d H:i', strtotime($request->auction_time)),
            'description' => $request->descripton,
            'image1' => $mainimage_path,
            'image2' => isset($imagetwo_path) ? $imagetwo_path : '',
            'image3' => isset($imagethree_path) ? $imagethree_path : '',
        ];
            // dd(date('Y-m-d H:i', strtotime($request->auction_time)));

        $product = Product::create($data);

        $size_id = $request->size_id;
        $product_id = $product->id;

        foreach($size_id as $key => $id)
        {
            $savesize = new AssignProductSize();

            $savesize->product_id = $product_id;
            $savesize->size_id = $size_id[$key];

            $savesize->save();
        }

        if($product){
            return redirect()->route('pendingAuctions')->with('success','product Added Successfully');
        }
    }

    public function editProduct($id)
    {
        $categories = Category::all();
        $product = Product::find($id);

            return view('Admin.product.update-product',compact('product','categories'));
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'category' => 'required',
            'actual_price' => 'required',
            'market_price' => 'required',
            'auction_price' => 'required',
            'new_main_image' => 'mimes:jpg,jpeg,png',
            'imagetwo' => 'mimes:jpg,jpeg,png',
            'imagethree' => 'mimes:jpg,jpeg,png',
        ]);

        $productId = $request->product_id;

        $product = Product::find($productId);
        
        $newDateTime = $request->new_auction_time;
        if($newDateTime){
            $updateDateTime = date('Y-m-d H:i', strtotime($request->new_auction_time));
        }else{
            $updateDateTime = $product->auction_time;
        }

        //  dd($updateDateTime);

        // get main Image
        $mainimage = $request->file('new_main_image');

        if(!empty($mainimage)){
            $Image1 = $mainimage->getClientOriginalName();
        }else{
            $Image1 = $product->image1;
        }   
        
        // get Image2
        $imagetwo = $request->file('imagetwo');

        if(!empty($imagetwo)){
            $Image2 = $imagetwo->getClientOriginalName();
        }else{
            $Image2 = $product->image2;
        }
            
        // get Image3
        $imagethree = $request->file('imagethree');

        if(!empty($imagethree)){
            $Image3 = $imagethree->getClientOriginalName();
        }else{
            $Image3 = $product->image3;
        }
            
        // make directory if not exists    
        $upload_dir = 'uploads/Product/';
        if(!is_dir($upload_dir)) 
            mkdir($upload_dir, 0755, true);

        // check if image2 and image3 exists to get path to store in DB

        if(!empty($mainimage)){
            $mainimage_path = str_replace(' ','_',$upload_dir.$Image1);
        }else{
            $mainimage_path = $Image1;
        }
        
        if(!empty($imagetwo)){
            $imagetwo_path = str_replace(' ','_',$upload_dir.$Image2);
        }else{
            $imagetwo_path = $Image2;
        }
           
        if(!empty($imagethree)) {
            $imagethree_path = str_replace(' ','_',$upload_dir.$Image3);
        }else{
            $imagethree_path = $Image3;
        }  
        
        //move Images to directory
        if(!empty($mainimage)){
            $mainimage->move($upload_dir,str_replace(' ','_',$Image1));
        }
        
        if(!empty($imagetwo)){
            $imagetwo->move($upload_dir,str_replace(' ','_',$Image2));
        }
        
        if(!empty($imagethree)){
            $imagethree->move($upload_dir,str_replace(' ','_',$Image3));
        }

        $data = [
            'name' => $request->name,
            'category_id' => $request->category,
            'actual_price' => $request->actual_price,
            'market_price' => $request->market_price,
            'auction_price' => $request->auction_price,
            'auction_time' => $updateDateTime,
            'description' => $request->descripton,
            'image1' => $mainimage_path,
            'image2' => isset($imagetwo_path) ? $imagetwo_path : '',
            'image3' => isset($imagethree_path) ? $imagethree_path : '',
        ];

        //  dd(date('Y-m-d H:i', strtotime($request->new_auction_time)));

        $update_product = $product->update($data);

        if($update_product)
        {
            $size_id = $request->size_id;
            $product_id = $request->product_id;
            $flag = $request->flag;

            $getSizes = AssignProductSize::where('product_id', $product_id)->update(['status' => 0]);
            foreach($size_id as $key => $id)
            {
                $savesize = AssignProductSize::updateOrInsert(['product_id' => $product_id, 'size_id' => $id],['size_id' => $id,'product_id' => $product_id, 'status' => 1]);
            }
        }
            return redirect()->route('pendingAuctions')->with('success','Product Updated Successfully');
       
    }

    public function deleteProduct($id)
    {
        $size = Product::where('id',$id)->delete();
            return redirect()->route('productList')->with('success','Product deleted');
    }

    public function changeProductStatus(Request $request, $id)
    {

        $updateStatus = Product::find($id);
        $status = [
            'status' => $request->status,
        ];
        
        $updateStatus->update($status);
        
            return redirect()->route('productList')->with('success','Product Status change Successfully');

    }

    public function pendingAuctions()
    {
        $pendingAuctions = Product::where('auction_status',0)->orderBy('auction_time','ASC')->paginate(25);

            return view('Admin.auctions.pending',compact('pendingAuctions'));
    }

    public function activeAuctions()
    {
        $activeAuctions = Product::with('category')->where('auction_status',1)
        ->whereHas('AuctionStart',function($query){
            $query->select('id','last_user_id','current_bid_used','current_price')
            ->with([
                'users' => function($q){
                    $q->select('id','name');
                },
            ]);
        })
        ->orderBy('auction_time','ASC')->paginate(25);
        
            return view('Admin.auctions.active',compact('activeAuctions'));
    }

    public function completedAuctions()
    {
        $completedAuctions = Product::with(['category','winner.user'])->where('auction_status',2)->paginate(25);;
        // dd($completedAuctions);
            return view('Admin.auctions.expire',compact('completedAuctions'));
    }

    public function changeAuctionStatus(Request $request, $id)
    {

        $updateStatus = Product::find($id);
        $status = [
            'status' => $request->status,
        ];
        
        $updateStatus->update($status);
        
            return redirect()->back()->with('success','Product Status change Successfully');
    }

    public function previewProduct($id)
    {
        // product data
        $product = Product::with('category')->find($id);
        $sizes_id = AssignProductSize::where('product_id',$product->id)->where('status',1)->pluck('size_id');
        $sizenames = ProductSize::whereIn('id',$sizes_id)->get();

        // dd($product);
        
        return view('Admin.product.view-product',compact('product','sizenames'));
    }

    public function previewActiveProduct($id)
    {
        $product = Product::with('category')->find($id);
        $sizes_id = AssignProductSize::where('product_id',$product->id)->where('status',1)->pluck('size_id');
        $sizenames = ProductSize::whereIn('id',$sizes_id)->get();

        $auctin_start = AuctionStart::where('auction_id',$product->id)->first();
        
        // Active auctions preview
        $activepreview = AuctionBidUsed::with(['product','users','auctionStart'])->where('auction_id',$product->id)->paginate(25);

        //  dd($activepreview);
        
        return view('Admin.product.view-active-product',compact('product','activepreview','auctin_start','sizenames'));
    }

    public function previewCompletedProduct($id)
    {
        $product = Product::with('category')->find($id);
        $sizes_id = AssignProductSize::where('product_id',$product->id)->where('status',1)->pluck('size_id');
        $sizenames = ProductSize::whereIn('id',$sizes_id)->get();

        // complete auctions preview

        $completeview = AuctionBidUsed::with(['product','users','winner'])->where('auction_id',$product->id)->orderBy('id','DESC')->paginate(25);

        $winner = Winner::where('product_id',$product->id)->first();

        //   dd($winner);
        
        return view('Admin.product.view-complete-product',compact('product','completeview','winner','sizenames'));
    }


    public function pdf()
    {
        $get_completed_auctions = Winner::where('email_status',0)->get();

        foreach($get_completed_auctions as $completed)
        {
            $product = Product::with('sizes')->where('id',$completed->product_id)->first();
            $sizes_id = AssignProductSize::where('product_id',$product->id)->where('status',1)->pluck('size_id');
            $sizenames = ProductSize::whereIn('id',$sizes_id)->get();
            $customer = User::where('id',$completed->user_id)->first();
            $auction = AuctionStart::where('auction_id',$completed->product_id)->first();
            $winner_bids = AuctionBidUsed::where('user_id',$customer->id)->where('auction_id',$product->id)->first();
            $losers = Loser::with('auctionLoser')->where('auction_id',$completed->product_id)->get();
            $shipping_Address = UserShippingAddress::with('address')->where('auction_id',$product->id)->first();

            $real_bids = AuctionBidUsed::whereHas('users', function($query){
                $query->where('roles','=', 'customer');
            })
            ->where('auction_id',$product->id)->sum('bid_used');

            $dummy_bids = AuctionBidUsed::whereHas('users', function($query){
                $query->where('roles','=', 'bot');
            })
            ->where('auction_id',$product->id)->sum('bid_used');
        }
            return view('emails/auction-completed', compact('product','completed','sizenames','customer','auction','losers','winner_bids','shipping_Address','real_bids','dummy_bids'));

        // $pdf = PDF::loadView('emails/auction-completed', compact('product'));
        //         // dd($pdf);
        //     return $pdf;
    }

    public function iFrameAuctions()
    {
        $data['auctionList'] = Product::where('status',1)->where('auction_status',0)->take(4)->get();
        // dd($auctionList);

        $data['secondList'] = Product::where('status',1)->where('auction_status',0)->skip(4)->take(100)->get();
        // dd($data['secondList']);

        if(count($data['secondList']) < 1){
            
            $data['secondList'] = $data['auctionList'];
        }
        return view('Admin.product.iframe',compact('data'));
    }

}
