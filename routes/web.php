<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\ProductController;
use PHPUnit\TextUI\XmlConfiguration\Group;

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



Route::middleware('admin:admin')->group(function (){
    Route::get('admin/login',[AdminController::class,'loginForm']);
    Route::post('admin/login',[AdminController::class,'store'])->name('admin.login');
});

Route::middleware(['auth:sanctum,admin',config('jetstream.auth_session'),'verified'
])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');
});


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


//Admin all routes


Route::controller(AdminController::class)->group(function (){
    Route::get('/admin/logout','destroy')->name('admin.logout')->middleware('auth');


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
        Route::post('/update','categoryUpdate')->name('category.update');
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



    });
});

Route::controller(AdminProfileController::class)->group(function (){
    Route::get('/admin/profile','adminProfile')->name('admin.profile');
    Route::get('/admin/profile/edit','adminProfileEdit')->name('admin.profile.edit');
    Route::post('/admin/profile/store','adminProfileStore')->name('admin.profile.store');
    Route::get('/admin/change/password','adminChangePassword')->name('admin.change.password');
    Route::post('/update/change/password','adminUpdateChangePassword')->name('update.change.password');



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








