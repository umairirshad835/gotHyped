<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductSize;

class ProductSizeController extends Controller
{
    public function sizeList()
    {
        $sizeList = ProductSize::where('status',1)->paginate(25);
        //  dd($sizeList);
            return view('Admin.size.index',compact('sizeList'));
    }

    public function inActiveSizeList()
    {
        $InActivesize = ProductSize::where('status',0)->paginate(25);
        return view('Admin.size.inactveSize',compact('InActivesize'));
    }

    public function addSize()
    {
        $all_category = Category::all();
        
        return view('Admin.size.add-size',compact('all_category'));
    }

    public function saveSize(Request $request){
        
        $request->validate([
            'name' => 'required|max:50',
            'status' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];

        $size = ProductSize::create($data);

        if($size){
            return redirect()->route('sizeList')->with('success','Size Save Successfully');
        }
    }

    public function editSize($id){

        $categories = Category::all();
        $size = ProductSize::find($id);
            return view('Admin.size.update-size',compact('size','categories'));
    }

    public function updateSize(Request $request){

        $request->validate([
            'name' => 'max:50',
        ]);

        $size_id = $request->size_id;
        $size_name = $request->name;
        $size_status = $request->status;

        $find_size = ProductSize::find($size_id);

        $data = [
            'name' => $size_name,
            'status' => $size_status,
        ];

        $find_size->update($data);
            return redirect()->route('sizeList')->with('success','Size Updated Successfully');
       
    }

    public function deleteSize($id){
        $size = ProductSize::where('id',$id)->delete();
            return redirect()->route('sizeList')->with('success','Size deleted');
    }

    public function changeSizeStatus(Request $request, $id){

        $updateStatus = ProductSize::find($id);
        $status = [
            'status' => $request->status,
        ];
        
        $updateStatus->update($status);
        
            return redirect()->route('sizeList')->with('success','Size Status change Successfully');
    }
}
