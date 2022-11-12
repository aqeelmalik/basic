<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

//Routes of the Project

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    echo "this is home page";
});
Route::get('/contact-us',[ContactController::class, 'index'])->name('con');
Route::get('/about', function () {
    return view('about');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
