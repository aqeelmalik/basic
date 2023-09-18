<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Brand;
use function PHPUnit\Framework\directoryExists;
use function PHPUnit\Framework\exactly;
use Image;

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
//        $image_name = time().'.'.$image->getClientOriginalExtension();
//        $destinationPath = base_path('public\image\brand');
//        $image->move($destinationPath, $image_name);

        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,200)->save('image/brand/'.$name_gen);
        $image_name = $name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $image_name,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->back()->with('success','Brand Successfully inserted');
    }

    public function EditBrand($id){
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function UpdateBrand(Request $request, $id){
        $validated = $request->validate([
            'brand_name' => 'required|min:4',
        ],
            [
                'brand_name.required' => 'Please write Brand name',
                'brand_name.min' => 'Brand Name must be longer then 4 character',
            ]);
//        call the old image
        $path = public_path().'/image/brand/';
        $old_image = $path.$request->old_image;
        if(!empty( $request->file('brand_image'))){
                $image = $request->file('brand_image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = base_path('public\image\brand');
                $image->move($destinationPath, $image_name);

//        remove the old image to update new one
                unlink($old_image);
                Brand::find($id)->update([
                    'brand_name' => $request->brand_name,
                    'brand_image' => $image_name,
                    'created_at' => Carbon::now(),
                ]);
                return redirect()->back()->with('success', 'Brand Successfully Updated');
        }else{
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success','Brand Successfully Updated');
        }

    }

    public function DeleteBrand(Request $request, $id){
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        if($request->hasFile($old_image)){
            if (Input::file($old_image)->isValid()) {
                unlink($old_image);
            }
        }
        Brand::find($id)->delete();
        return redirect()->back()->with('success','Brand Deleted Updated');

    }


}
