<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //show all categories
    public function AllCat()
    {
        // Note that when we user joins in query builder then we dont require models function.
        // So better is to remove function from model

        //Join table using Query Builder
//        $categories = DB::table('categories')
//            ->join('users','categories.user_id','users.id')
//            ->select('categories.*','users.name')
//            ->latest()->paginate(5);

        //Read data using Eloquent ORM method
        $categories = Category::latest()->paginate(5);

        //Read data using Query Builder Method
//        $categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.category.index', compact('categories'));
    }

    //add single category
    public function AddCat(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
            [
                'category_name.required' => 'Please write Category name',
                'category_name.max' => 'Category must be less than 255 char',
            ]);

        //Insert data using Eloquent ORM method
        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        //2nd insert method
//        $category = new Category;
//        $category->category_name = $request->category_name;
//        $category->user_id = Auth::user()->id;
//        $category->save();

        //insert data using query builder
//        $data = array();
//        $data['category_name'] = $request->category_name;
//        $data['user_id'] = Auth::user()->id;
//        DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }

    public function EditCat($id){
        // Edit data using Eloquent ORM Method
        $categories = Category::find($id);
        return view('admin.category.edit', compact('categories'));
    }

    public function UpdateCat(Request $request ,$id){
        // Update data using Eloquent ORM Method
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);
        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');

    }
}
