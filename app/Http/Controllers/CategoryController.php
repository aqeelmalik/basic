<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    }
}