<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //show all categories
    public function AllCat()
    {
        return view('admin.category.index');
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
        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }
}
