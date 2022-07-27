<?php

namespace App\Http\Controllers\Backend;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function subCategoryView(){
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $subcategory =  SubCategory::latest()->get();

      return view('backend.category.subcategory_view',compact('subcategory','categories'));
    }

    public function subCategoryStore(Request $request){
        $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_fr' => 'required',
        ],

            [
                'category_id.required' => 'Please Select An Option',
                'subcategory_name_en.required' => 'Input SubCategory English Name',
                'subcategory_name_fr.required' => 'Input SubCategory French Name',


        ]);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_fr' => $request->subcategory_name_fr,
            'subcategory_slug_en' => strtolower(str_replace(' ','-',$request->subcategory_name_en)),
            'subcategory_slug_fr' => strtolower(str_replace(' ','-',$request->subcategory_name_fr)),

        ]);

        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function subCategoryEdit($id){
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $subcategory =  SubCategory::findOrFail($id);

        return view('backend.category.subcategory_edit',compact('subcategory','categories'));
    }

    public function subCategoryUpdate(Request $request){
        $subcat_id = $request->id;

    	 SubCategory::findOrFail($subcat_id)->update([
		'category_id' => $request->category_id,
		'subcategory_name_en' => $request->subcategory_name_en,
		'subcategory_name_fr' => $request->subcategory_name_fr,
		'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),
		'subcategory_slug_fr' => str_replace(' ', '-',$request->subcategory_name_fr),


    	]);

	    $notification = array(
			'message' => 'SubCategory Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.subcategory')->with($notification);

    }

    public function subCategoryDelete($id){
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);

    }


    //***************Sub Sub Category */

    public function subSubCategoryView(){

    }
}