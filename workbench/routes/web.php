<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
})->name('home');

Route::get('/lang/{lang}', function ($lang) {
    session()->put('lang', $lang);
    return back();
})->name('lang');

Route::get('/{category}', function () {
    return view('app');
})->name('category');