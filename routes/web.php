<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

//Routes of the Project
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    echo "this is home page";
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact-us',[ContactController::class, 'index'])->name('con');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // trying Eloquent ORM to Read User data
//        $users = User::all();

        //trying to read user data using query builder
        $users = DB::table('Users')->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});


//Categories Routes
Route::get('/category/all',[CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'AddCat'])->name('store.category');
Route::get('/category/edit/{id}',[CategoryController::class, 'EditCat']);
Route::Post('/category/update/{id}',[CategoryController::class, 'UpdateCat']);
Route::get('/category/softDelete/{id}',[CategoryController::class, 'SoftDelete']);
Route::get('/category/restore/{id}',[CategoryController::class, 'Restore']);
Route::get('/category/pdelete/{id}',[CategoryController::class, 'Pdelete']);


//Routes for Brand
Route::get('/brand/all',[BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/brand/add',[BrandController::class, 'StoreBrand'])->name('store.brand');
Route::get('/brand/edit/{id}',[BrandController::class, 'EditBrand']);
Route::Post('/brand/update/{id}',[BrandController::class, 'UpdateBrand']);
Route::get('/brand/delete/{id}',[BrandController::class, 'DeleteBrand']);

//Routes for Multi Images
Route::get('/multi/images',[BrandController::class, 'MultiPic'])->name('Multi.image');
Route::post('/multi/add',[BrandController::class, 'StoreImg'])->name('store.image');




