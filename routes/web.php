<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

//Routes of the Project

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    echo "this is home page";
});
Route::get('/contact-us',[ContactController::class, 'index'])->name('con');
Route::get('/category/all',[CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'AddCat'])->name('store.category');

Route::get('/about', function () {
    return view('about');
});

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
