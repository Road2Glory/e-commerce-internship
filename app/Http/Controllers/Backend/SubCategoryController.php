<?php

namespace App\Http\Controllers\Backend;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubSubCategory;

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

    public function SubSubCategoryView(){

 	$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subsubcategory = SubSubCategory::latest()->get();
    	return view('backend.category.sub_subcategory_view',compact('subsubcategory','categories'));

     }

    public function getSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name_en','ASC')->get();
     	return json_encode($subcat);
    }

    public function getSubSubCategory($subcategory_id){

        $subsubcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name_en','ASC')->get();
        return json_encode($subsubcat);
     }


    public function subSubCategoryStore(Request $request){
        $request->validate([
    		'category_id' => 'required',
    		'subcategory_id' => 'required',
    		'subsubcategory_name_en' => 'required',
    		'subsubcategory_name_fr' => 'required',
    	],[
    		'category_id.required' => 'Please select Any option',
    		'subsubcategory_name_en.required' => 'Input SubSubCategory English Name',
    	]);



	   SubSubCategory::insert([
		'category_id' => $request->category_id,
		'subcategory_id' => $request->subcategory_id,
		'subsubcategory_name_en' => $request->subsubcategory_name_en,
		'subsubcategory_name_fr' => $request->subsubcategory_name_fr,
		'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),
		'subsubcategory_slug_fr' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_fr)),


    	]);

	    $notification = array(
			'message' => 'Sub-SubCategory Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
}


    public function subSubCategoryEdit($id){
       $categories = Category::orderBy('category_name_en','ASC')->get();
    	$subcategories = SubCategory::orderBy('subcategory_name_en','ASC')->get();
    	$subsubcategories = SubSubCategory::findOrFail($id);
    	return view('backend.category.sub_subcategory_edit',compact('categories','subcategories','subsubcategories'));
    }

    public function subSubCategoryUpdate(Request $request){
        $subsubcat_id = $request->id;

    	SubSubCategory::findOrFail($subsubcat_id)->update([
		'category_id' => $request->category_id,
		'subcategory_id' => $request->subcategory_id,
		'subsubcategory_name_en' => $request->subsubcategory_name_en,
		'subsubcategory_name_fr' => $request->subsubcategory_name_fr,
		'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),
		'subsubcategory_slug_fr' => str_replace(' ', '-',$request->subsubcategory_name_fr),


    	]);

	    $notification = array(
			'message' => 'Sub-SubCategory Update Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.subsubcategory')->with($notification);
    }

    public function subSubCategoryDelete($id){

    	SubSubCategory::findOrFail($id)->delete();
    	 $notification = array(
			'message' => 'Sub-SubCategory Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    }

}
