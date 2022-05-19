<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\CategorySize;

class CategoryController extends Controller
{
    public function categoryList(){

        $categoryList = Category::paginate(25);
        return view('Admin.category.index',compact('categoryList'));
    }

    public function addCategory(){

        $sizes = ProductSize::all();
            return view('Admin.category.add-category',compact('sizes'));
    }

    public function saveCategory(Request $request){
        
        $request->validate([
            'name' => 'required|max:50',
            'status' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];

        $category = Category::create($data);

        $size_id = $request->size_id;
        $cat_id = $category->id;

        foreach($size_id as $key => $id){
            $savesize = new CategorySize();

            $savesize->cat_id = $cat_id;
            $savesize->size_id = $size_id[$key];

            $savesize->save();
        }

        if($category)
        {
            return redirect()->route('categoryList')->with('success','Category Save Successfully');
        }
    }

    public function editCategory($id){

        $category = Category::find($id);
            return view('Admin.category.update-category',compact('category'));
    }

    public function getSizes($id)
    {
        $data['sizes'] = ProductSize::all();
        $data['category_size'] = CategorySize::where('cat_id',$id)->get();
            return response()->json($data);
    }

    public function updateCategory(Request $request)
    {
        $request->validate([
            'name' => 'max:50',
            'status' => 'required',
        ]);

        // dd($request->all());

        $category_id = $request->category_id;
        $category_name = $request->name;
        $category_status = $request->status;

        // dd($category_status);

        $find_category = Category::find($category_id);
        
        $data = [
            'name' => $category_name,
            'status' => $category_status,
        ];

        $update_Category = $find_category->update($data);
        if($update_Category)
        {
            $size_id = $request->size_id;
            $cat_id = $request->category_id;
            // dd($size_id);

            $categorySizes = CategorySize::where('cat_id', $cat_id)->update(['status' => 0]);
            // dd($categorySizes);
            foreach($size_id as $id)
            {
                $savesize = CategorySize::updateOrInsert(['cat_id' => $cat_id, 'size_id' => $id],['size_id' => $id,'cat_id' => $cat_id, 'status' => 1]);
            }
            // $delete_size = CategorySize::where('cat_id', $cat_id)->whereNotIn('size_id',$size_id)->delete();
        }
            return redirect()->route('categoryList')->with('success','Category Updated Successfully');
       
    }

    public function deleteCategory($id){
        $category = Category::where('id',$id)->delete();

        return redirect()->route('categoryList')->with('success','Category deleted');
    }

    public function changeCategoryStatus(Request $request, $id){

        $updateStatus = Category::find($id);
        $status = [
            'status' => $request->status,
        ];
        
        $updateStatus->update($status);
        
            return redirect()->route('categoryList')->with('success','Category Status change Successfully');
    }

}
