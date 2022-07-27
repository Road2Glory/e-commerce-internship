<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class BrandController extends Controller
{
    public function brandView(){
      $brands =  Brand::latest()->get();

      return view('backend.brand.brand_view',compact('brands'));
    }

    public function brandStore(Request $request){
        $request->validate([
            'brand_name_eng' => 'required',
            'brand_name_fr' => 'required',
            'brand_image' => 'required',],

            [
                'brand_name_eng.required' => 'Input Brand English Name',
                'brand_name_fr.required' => 'Input Brand french Name',

        ]);

        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);

        $save_url = 'upload/brand/'.$name_gen;

        Brand::insert([
            'brand_name_eng' => $request->brand_name_eng,
            'brand_name_fr' => $request->brand_name_fr,
            'brand_slug_en' => strtolower(str_replace(' ','-',$request->brand_name_eng)),
            'brand_slug_fr' => strtolower(str_replace(' ','-',$request->brand_name_fr)),
            'brand_image' =>$save_url ,
        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);




    }

    public function brandEdit($id){
        $brand = Brand::findOrFail($id);

        return view('backend.brand.brand_edit',compact('brand'));
    }

    public function brandUpdate(Request $request){
        $brand_id = $request->id;
        $old_image = $request->old_image;

        if ($request->file('brand_image')) {
            # code...
            unlink($old_image);
            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);

            $save_url = 'upload/brand/'.$name_gen;

            Brand::findOrFail($brand_id)->update([
                'brand_name_eng' => $request->brand_name_eng,
                'brand_name_fr' => $request->brand_name_fr,
                'brand_slug_en' => strtolower(str_replace(' ','-',$request->brand_name_eng)),
                'brand_slug_fr' => strtolower(str_replace(' ','-',$request->brand_name_fr)),
                'brand_image' =>$save_url ,
            ]);

            $notification = array(
                'message' => 'Brand Updated with Image Successfully',
                'alert-type' => 'info'
            );

            return redirect()->route('all.brand')->with($notification);
        }else{
            Brand::findOrFail($brand_id)->update([
                'brand_name_eng' => $request->brand_name_eng,
                'brand_name_fr' => $request->brand_name_fr,
                'brand_slug_en' => strtolower(str_replace(' ','-',$request->brand_name_eng)),
                'brand_slug_fr' => strtolower(str_replace(' ','-',$request->brand_name_fr)),

            ]);

            $notification = array(
                'message' => 'Brand Updated Without Image Successfully',
                'alert-type' => 'info'
            );

            return redirect()->route('all.brand')->with($notification);
        }
    }

    public function brandDelete($id){
        $brand = Brand::findOrFail($id);
        $img = $brand->brand_image;

        unlink($img);

        Brand::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    }
}
