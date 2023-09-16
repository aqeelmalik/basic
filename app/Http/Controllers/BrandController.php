<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Brand;
use function PHPUnit\Framework\exactly;

class BrandController extends Controller
{
    public function AllBrand(){
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index' , compact('brands'));
    }

    public function StoreBrand(Request $request){
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',
        ],
            [
                'brand_name.required' => 'Please write Brand name',
                'brand_name.min' => 'Brand Name must be longer then 4 character',
            ]);
        $image = $request->file('brand_image');
        $image_name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = base_path('public\image\brand');
        $image->move($destinationPath, $image_name);
        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $image_name,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->back()->with('success','Brand Successfully inserted');
    }
}
