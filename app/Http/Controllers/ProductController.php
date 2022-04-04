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


class ProductController extends Controller
{
    public function productList()
    {

        $productList = Product::with('category')->paginate(25);
        return view('Admin.product.index',compact('productList'));
    }

    public function addProduct()
    {
        $all_category = Category::all();
            return view('Admin.product.add-product',compact('all_category'));
    }

    public function getSizes($id)
    {
        $category_size = CategorySize::where('cat_id',$id)->pluck('size_id');
        $size = ProductSize::whereIn('id',$category_size)->get();
            return response()->json($size);
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
        $upload_dir = 'uploads';
        if(!is_dir($upload_dir)) 
            mkdir($upload_dir, 0755, true);

        $product_dir = $upload_dir.'/'.$request->name;
        if(!is_dir($product_dir)) 
            mkdir($product_dir, 0755, true);
        
        
        // check if image2 and image3 exists to get path to store in DB
        $mainimage_path = $product_dir.'/'.$Image1;

        if(!empty($Image2)){
            $imagetwo_path = $product_dir.'/'.$Image2;
        }
           
        if(!empty($Image3)) {
            $imagethree_path = $product_dir.'/'.$Image3;
        }  
        
        //move Images to directory
        $mainimage->move($product_dir,$Image1);

        if(!empty($imagetwo)){
            $imagetwo->move($product_dir,$Image2);
        }
        if(!empty($imagethree)){
            $imagethree->move($product_dir,$Image3);
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
            return redirect()->route('productList')->with('success','product Save Successfully');
        }
    }

    public function editProduct($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        // dd($product);
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
            $updateDateTime = $request->new_auction_time;
        }else{
            $updateDateTime = $product->auction_time;
        }

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
        $upload_dir = 'uploads';
        if(!is_dir($upload_dir)) 
            mkdir($upload_dir, 0755, true);

        $product_dir = $upload_dir.'/'.$request->name;
        if(!is_dir($product_dir)) 
            mkdir($product_dir, 0755, true);
        
        
        // check if image2 and image3 exists to get path to store in DB

        if(!empty($mainimage)){
            $mainimage_path = $product_dir.'/'.$Image1;
        }else{
            $mainimage_path = $Image1;
        }
        
        if(!empty($imagetwo)){
            $imagetwo_path = $product_dir.'/'.$Image2;
        }else{
            $imagetwo_path = $Image2;
        }
           
        if(!empty($imagethree)) {
            $imagethree_path = $product_dir.'/'.$Image3;
        }else{
            $imagethree_path = $Image3;
        }  
        
        //move Images to directory
        if(!empty($mainimage)){
            $mainimage->move($product_dir,$Image1);
        }
        
        if(!empty($imagetwo)){
            $imagetwo->move($product_dir,$Image2);
        }
        
        if(!empty($imagethree)){
            $imagethree->move($product_dir,$Image3);
        }

        $data = [
            'name' => $request->name,
            'category_id' => $request->category,
            'actual_price' => $request->actual_price,
            'market_price' => $request->market_price,
            'auction_price' => $request->auction_price,
            'auction_time' => date('Y-m-d H:i', strtotime($request->new_auction_time)),
            'description' => $request->descripton,
            'image1' => $mainimage_path,
            'image2' => isset($imagetwo_path) ? $imagetwo_path : '',
            'image3' => isset($imagethree_path) ? $imagethree_path : '',
        ];

        // dd(date('Y-m-d H:i', strtotime($request->new_auction_time)));

        $product->update($data);
            return redirect()->route('productList')->with('success','Product Updated Successfully');
       
    }

    public function deleteProduct($id)
    {
        $size = Product::where('id',$id)->delete();
            return redirect()->route('productList')->with('success','Product deleted');
    }

    public function assignSize($id)
    {
        $product = Product::find($id);
        $categorySizes = CategorySize::where('cat_id',$product->category_id)->pluck('size_id');
        $sizes = ProductSize::whereIn('id',$categorySizes)->get();

        return view('Admin.product.assign-size',compact('sizes','product'));
    }

    public function saveProductSize(Request $request)
    {
        $size_id = $request->size_id;
        $product_id = $request->product_id;
        foreach($size_id as $key => $id)
        {
            $savesize = new AssignProductSize();

            $savesize->product_id = $product_id;
            $savesize->size_id = $size_id[$key];

            $savesize->save();

        }
        return redirect()->route('productList')->with('success','Size Assigned Successfully');
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
        $activeAuctions = Product::where('auction_status',1)->orderBy('auction_time','ASC')->paginate(25);
        
            return view('Admin.auctions.active',compact('activeAuctions'));
    }

    public function completedAuctions()
    {
        $completedAuctions = Product::where('auction_status',2)->orderBy('auction_time','ASC')->paginate(25);
        
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
        $sizes_id = AssignProductSize::where('product_id',$product->id)->pluck('size_id');
        $sizenames = ProductSize::whereIn('id',$sizes_id)->get();

        
        // Winner data of Auction
        $winner = Winner::with(['user','shippingAddress.address'])->where('product_id',$product->id)->first();
        //  dump($winner);

        $user_bot = Winner::with(['user'])->where('product_id',$product->id)->first();
        $user = User::where('id',$user_bot->user_id)->first();
        
        
        return view('Admin.product.view-product',compact('product','sizenames','winner','user'));
    }

}
