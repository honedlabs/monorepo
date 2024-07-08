<?php

use Illuminate\Routing\Route;

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