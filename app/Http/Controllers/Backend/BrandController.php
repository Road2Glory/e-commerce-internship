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
}
