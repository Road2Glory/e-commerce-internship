<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function reviewStore(Request $request){
        $product = $request->product_id;

    	$request->validate([

    		'summary' => 'required',
    		'comment' => 'required',
    	]);

    	Review::insert([
    		'product_id' => $product,
    		'user_id' => Auth::id(),
    		'comment' => $request->comment,
    		'summary' => $request->summary,
    		'created_at' => Carbon::now(),

    	]);

    	$notification = array(
			'message' => 'Review Will Be Approved By Admin',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
    }


    public function pendingReview(){
        $review = Review::where('status',0)->orderBy('id','DESC')->get();
    	return view('backend.review.pending_review',compact('review'));

    }

    public function reviewRequestApprove($id){
        Review::where('id',$id)->update(['status' => 1]);

    	$notification = array(
            'message' => 'Review Approved Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function publishReview(){
        $review = Review::where('status',1)->orderBy('id','DESC')->get();
    	return view('backend.review.publish_review',compact('review'));
    }


    public function deleteReview($id){

    	Review::findOrFail($id)->delete();

    	$notification = array(
            'message' => 'Review Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method
}
