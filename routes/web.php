<?php

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Http\Controllers\User\CashController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Frontend\HomeBlogController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\User\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login',[AdminController::class, 'store'])->name('admin.login');
});


Route::middleware(['auth:admin'])->group(function (){



Route::middleware(['auth:sanctum,admin',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');
});


// Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });


//Admin all routes


Route::controller(AdminController::class)->group(function (){
    Route::get('/admin/logout','destroy')->name('admin.logout')->middleware('auth');


});



Route::controller(AdminProfileController::class)->group(function (){
    Route::get('/admin/profile','adminProfile')->name('admin.profile');
    Route::get('/admin/profile/edit','adminProfileEdit')->name('admin.profile.edit');
    Route::post('/admin/profile/store','adminProfileStore')->name('admin.profile.store');
    Route::get('/admin/change/password','adminChangePassword')->name('admin.change.password');
    Route::post('/update/change/password','adminUpdateChangePassword')->name('update.change.password');



});


});


//Brand All route
Route::prefix('brand')->group(function (){
    Route::controller(BrandController::class)->group(function (){
        Route::get('/view','brandView')->name('all.brand');
        Route::post('/store','brandStore')->name('brand.store');
        Route::get('/edit/{id}','brandEdit')->name('brand.edit');
        Route::post('/update','brandUpdate')->name('brand.update');
        Route::get('/delete/{id}','brandDelete')->name('brand.delete');


    });

});


//Admin Category routes
Route::prefix('category')->group(function (){
    Route::controller(CategoryController::class)->group(function (){
        Route::get('/view','categoryView')->name('all.category');
        Route::post('/store','categoryStore')->name('category.store');
        Route::get('/edit/{id}','categoryEdit')->name('category.edit');
        Route::post('/update/{id}','categoryUpdate')->name('category.update');
        Route::get('/delete/{id}','categoryDelete')->name('category.delete');


    });

    Route::controller(SubCategoryController::class)->group(function (){
        Route::get('/sub/view','subCategoryView')->name('all.subcategory');
        Route::post('/sub/store','subCategoryStore')->name('subcategory.store');
        Route::get('/sub/edit/{id}','subCategoryEdit')->name('subcategory.edit');
        Route::post('/sub/update','subCategoryUpdate')->name('subcategory.update');
        Route::get('/sub/delete/{id}','subCategoryDelete')->name('subcategory.delete');


        //Admin subsubcategory
        Route::get('/sub/sub/view','subSubCategoryView')->name('all.subsubcategory');
        Route::get('/subcategory/ajax/{category_id}','getSubCategory');
        Route::get('/sub-subcategory/ajax/{subcategory_id}','getSubSubCategory');
        Route::post('/sub/sub/store','subSubCategoryStore')->name('subsubcategory.store');
        Route::get('/sub/sub/edit/{id}','subSubCategoryEdit')->name('subsubcategory.edit');
        Route::post('/sub/sub/update','subSubCategoryUpdate')->name('subsubcategory.update');
        Route::get('/sub/sub/delete/{id}','subSubCategoryDelete')->name('subsubcategory.delete');


    });



});


//ADmin Products All routes
Route::prefix('product')->group(function (){
    Route::controller(ProductController::class)->group(function (){
        Route::get('/add','addProduct')->name('add-product');
        Route::post('/store','storeProduct')->name('product-store');
        Route::get('/manage','manageProduct')->name('manage-product');
        Route::get('/edit/{id}','editProduct')->name('product.edit');
        Route::post('/data/update','productDataUpdate')->name('product-update');
        Route::post('/image/update','multiImageUpdate')->name('update-product-image');
        Route::post('/thumbnail/update','thumbnailImageUpdate')->name('update-product-thumbnail');
        Route::get('/multiimg/delete/{id}','multiImageDelete')->name('product.multiimg.delete');
        Route::get('/inactive/{id}','productInactive')->name('product.inactive');
        Route::get('/active/{id}','productActive')->name('product.active');
        Route::get('/delete/{id}','productDelete')->name('product.delete');



    });
});


//slider
Route::prefix('slider')->group(function (){
    Route::controller(SliderController::class)->group(function (){
        Route::get('/view','sliderView')->name('manage-slider');
        Route::post('/store','sliderStore')->name('slider.store');
        Route::get('/edit/{id}','sliderEdit')->name('slider.edit');
        Route::post('/update','sliderUpdate')->name('slider.update');
        Route::get('/delete/{id}','sliderDelete')->name('slider.delete');
        Route::get('/inactive/{id}','sliderInactive')->name('slider.inactive');
        Route::get('/active/{id}','sliderActive')->name('slider.active');


    });
});




//User All routes

Route::middleware(['auth:sanctum,web','verified'])->get('/dashboard',function (){
    $id = Auth::user()->id;
        $user = User::find($id);
    return view('dashboard',compact('user'));
})->name('dashboard');

Route::controller(IndexController::class)->group(function (){
    Route::get('/','index');
    Route::get('/user/logout','userLogout')->name('user.logout');
    Route::get('/user/profile','userProfile')->name('user.profile');
    Route::post('/user/profile/store','userProfileStore')->name('user.profile.store');
    Route::get('/user/change/password','userChangePassword')->name('change.password');
    Route::post('/user/password/update','userPasswordUpdate')->name('user.password.update');

});

///////frontEND ALL routes1/////////////

Route::controller(LanguageController::class)->group(function (){
    Route::get('/language/french','French')->name('french.language');
    Route::get('/language/english','English')->name('english.language');
});

// frontend product details page
Route::controller(IndexController::class)->group(function (){
    Route::get('/product/details/{id}/{slug}','productDetails');
    //product tags page
    Route::get('/product/tag/{tag}','tagWiseProduct');
    //suubcategory wise data frontend

    Route::get('/subcategory/product/{subcat_id}/{slug}','subCateWiseProduct');
    //suubsubcategory wise data frontend
    Route::get('/subsubcategory/product/{subsubcat_id}/{slug}','subSubCateWiseProduct');

    //product view modal with ajax
    Route::get('/product/view/modal/{id}','productViewAjax');
});


Route::controller(CartController::class)->group(function (){
    //add to cart store data
    Route::post('/cart/data/store/{id}','addToCart');
    //get data from mini cart
    Route::get('/product/mini/cart/','addMiniCart');
    //remove data from mini cart
    Route::get('/minicart/product-remove/{rowId}','removeMiniCart');

   //add to cart store data
   Route::post('/add-to-wishlist/{product_id}','addToWishlist');

//    ------------------------------------------------------------

//frontend ciupon option

    Route::post('/coupon-apply','couponApply');
    Route::get('/coupon-calculation','couponCalculation');
    Route::get(' /coupon-remove','couponRemove');

  //  ------------------------------------------------------


     Route::get('/checkout','checkoutCreate')->name('checkout');






});


Route::group(['prefix'=>'user','middleware' => ['user','auth']],function(){

Route::controller(WishlistController::class)->group(function (){
     //wishlist page
   Route::get('/wishlist','viewWishlist')->name('wishlist');
   Route::get('/get-wishlist-product','getWishlistProduct');
   Route::get('/wishlist-remove/{id}','removeWishlistProduct');

});

Route::controller(StripeController::class)->group(function (){
    Route::post('/stripe/order','stripeOrder')->name('stripe.order');
});

Route::controller(AllUserController::class)->group(function (){
    Route::get('/my/orders','myOrders')->name('my.orders');
    Route::get('/order_details/{order_id}','orderDetails');
    Route::get('/invoice_download/{order_id}','invoiceDownload');
    Route::post('/return/order/{order_id}','returnOrder')->name('return.order');
    Route::get('/return/order/list','returnOrderList')->name('return.order.list');
    Route::get('/cancel/orders','cancelOrders')->name('cancel.orders');


});

Route::controller(CashController::class)->group(function (){
    Route::post('/cash/order','cashOrder')->name('cash.order');
});




});

// My cart page all routes
Route::controller(CartPageController::class)->group(function (){
    Route::get('/user/mycart','myCart')->name('mycart');
    Route::get('/user/get-cart-product','getCartProduct');
    Route::get('/user/cart-remove/{rowId}','removeCartProduct');
    Route::get('/cart-increment/{rowId}','cartIncrement');
    Route::get('/cart-decrement/{rowId}','cartDecrement');




 });

  //ADmin coupons routes
 Route::prefix('coupons')->group(function (){
    Route::controller(CouponController::class)->group(function (){
        Route::get('/view','couponView')->name('manage-coupon');
        Route::post('/store','couponStore')->name('coupon.store');
        Route::get('/edit/{id}','couponEdit')->name('coupon.edit');
        Route::post('/update/{id}','couponUpdate')->name('coupon.update');
        Route::get('/delete/{id}','couponDelete')->name('coupon.delete');




    });
});


  //ADmin shipping routes
  Route::prefix('shipping')->group(function (){
    Route::controller(ShippingAreaController::class)->group(function (){
        //shipping division
        Route::get('/division/view','divisionView')->name('manage-division');
        Route::post('/division/store','divisionStore')->name('division.store');
        Route::get('/division/edit/{id}','divisionEdit')->name('division.edit');
        Route::post('/division/update/{id}','divisionUpdate')->name('division.update');
        Route::get('/division/delete/{id}','divisionDelete')->name('division.delete');


        //shipping district
        Route::get('/district/view','districtView')->name('manage-district');
        Route::post('/district/store','districtStore')->name('district.store');
        Route::get('/district/edit/{id}','districtEdit')->name('district.edit');
         Route::post('/district/update/{id}','districtUpdate')->name('district.update');
         Route::get('/district/delete/{id}','districtDelete')->name('district.delete');


         //shipping state
        Route::get('/state/view','stateView')->name('manage-state');
        Route::post('/state/store','stateStore')->name('state.store');
        Route::get('/state/edit/{id}','stateEdit')->name('state.edit');
         Route::post('/state/update/{id}','stateUpdate')->name('state.update');
         Route::get('/state/delete/{id}','stateDelete')->name('state.delete');



    });
});

Route::controller(CheckoutController::class)->group(function (){
    Route::get('/district-get/ajax/{division_id}','districtGetAjax');
    Route::get('/state-get/ajax/{district_id}','stateGetAjax');
    Route::post('/checkout/store','checkoutStore')->name('checkout.store');
});


  //ADmin orders routes
  Route::prefix('orders')->group(function (){
    Route::controller(OrderController::class)->group(function (){
        Route::get('/pending/orders','pendingOrders')->name('pending-orders');
        Route::get('/pending/orders/details/{order_id}','pendingOrdersDetails')->name('pending.order.details');
        Route::get('/confirmed/orders','confirmedOrders')->name('confirmed-orders');
        Route::get('/processing/orders','processingOrders')->name('processing-orders');
        Route::get('/picked/orders','pickedOrders')->name('picked-orders');
        Route::get('/shipped/orders','shippedOrders')->name('shipped-orders');
        Route::get('/delivered/orders','deliveredOrders')->name('delivered-orders');
        Route::get('/cancel/orders','cancelOrders')->name('cancel-orders');
        //update status
        Route::get('/pending/confirm/{order_id}','pendingToConfirm')->name('pending-confirm');
        Route::get('/confirm/processing/{order_id}','confirmToProcessing')->name('confirm.processing');
        Route::get('/processing/picked/{order_id}','processingToPicked')->name('processing.picked');
        Route::get('/picked/shipped/{order_id}','pickedToShipped')->name('picked.shipped');
        Route::get('/shipped/delivered/{order_id}','shippedToDelivered')->name('shipped.delivered');
        // Route::get('/cancelled/delivery/{order_id}','cancelledOrder')->name('cancelled');
        Route::get('/invoice/download/{order_id}','adminInvoiceDownload')->name('invoice.download');







    });
});

Route::prefix('reports')->group(function (){
    Route::controller(ReportController::class)->group(function(){
        Route::get('/view','reportView')->name('all-reports');
        Route::post('/serach/by/date','reportByDate')->name('search-by-date');
        Route::post('/serach/by/month','reportByMonth')->name('search-by-month');
        Route::post('/serach/by/year','reportByYear')->name('search-by-year');
    });
});


//Admin get all users
Route::prefix('alluser')->group(function (){
    Route::controller(AdminProfileController::class)->group(function(){
        Route::get('/view','allUsers')->name('all-users');

    });
});


Route::prefix('blog')->group(function (){
    Route::controller(BlogController::class)->group(function(){
        Route::get('/category','blogCategory')->name('blog.category');
        Route::post('/store','blogCategoryStore')->name('blogcategory.store');
        Route::get('/category/edit/{id}','blogCategoryEdit')->name('blog.category.edit');
        Route::post('/update','blogCategoryUpdate')->name('blogcategory.update');
        Route::get('/category/delete/{id}','blogCategoryDelete')->name('blog.category.delete');


    });

    Route::controller(BlogController::class)->group(function(){
        Route::get('/add/post','addBlogPost')->name('add.post');
        Route::get('/list/post','listBlogPost')->name('list.post');
        Route::post('/post/store','blogPostStore')->name('post-store');
        Route::get('/post/edit/{id}','blogPostEdit')->name('blog.post.edit');
        Route::get('/post/delete/{id}','blogPostDelete')->name('blog.post.delete');




    });


});



Route::controller(HomeBlogController::class)->group(function(){
    //frontend blog routes
    Route::get('/blog','addBlogPost')->name('home.blog');
    Route::get('/post/details/{id}','detailsBlogPost')->name('post.details');
    Route::get('/blog/category/post/{category_id}','homeBlogCatPost');

});



//site setting routes
Route::prefix('setting')->group(function (){
    Route::controller(SiteSettingController::class)->group(function(){
        Route::get('/site','siteSetting')->name('site.setting');
        Route::post('/site/update','siteSettingUpdate')->name('update.sitesetting');

    });


});


//admin return order  routes
Route::prefix('return')->group(function (){
    Route::controller(ReturnController::class)->group(function(){
        Route::get('/admin/request','returnRequest')->name('return.request');
        Route::get('/admin/return/approve/{order_id}',  'ReturnRequestApprove')->name('return.approve');

        Route::get('/admin/all/request','ReturnAllRequest')->name('all.request');


    });


});

////////////frontend product review routes

Route::controller(ReviewController::class)->group(function (){
    Route::post('/review/store','reviewStore')->name('review.store');
});

/////////////

Route::prefix('review')->group(function (){
    Route::controller(ReviewController::class)->group(function(){
        Route::get('/pending','pendingReview')->name('pending.review');
        Route::get('/admin/approve/{id}','reviewRequestApprove')->name('review.approve');

        Route::get('/publish','publishReview')->name('publish.review');

        Route::get('/delete/{id}','deleteReview')->name('delete.review');



    });


});



Route::prefix('stock')->group(function (){
    Route::controller(ProductController::class)->group(function(){
        Route::get('/product','productStock')->name('product.stock');



    });


});


////////////////ADMIN USER ROLE

Route::prefix('adminuserrole')->group(function (){
    Route::controller(AdminUserController::class)->group(function(){
        Route::get('/all','allAdminRole')->name('all.admin.user');
        Route::get('/add','addAdminRole')->name('add.admin');
        Route::post('/store','storeAdminRole')->name('admin.user.store');


    });

});


















