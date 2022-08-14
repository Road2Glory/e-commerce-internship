<?php

namespace App\Http\Controllers\User;

use App\Models\Wishlist;
use function Ramsey\Uuid\v1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Auth;

class WishlistController extends Controller
{
    public function viewWishlist(){
		return view('frontend.wishlist.view_wishlist');
	}

    public function getWishlistProduct(){
        $wishlist = Wishlist::with('product')->where('user_id',Auth::id())->latest()->get();

        return response()->json($wishlist);
    }


    public function removeWishlistProduct($id){
        Wishlist::where('user_id',Auth::id())->where('id',$id)->delete();


        return response()->json(['success' => 'Successfully Product Removed']);
    }
}
