<?php

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\User\CheckoutController;

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
});













