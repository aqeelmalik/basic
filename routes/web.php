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
Route::get('/contact',[ContactController::class, 'index']);
Route::get('/about', function () {
    return view('about');
})->middleware('check');
