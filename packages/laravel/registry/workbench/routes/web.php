<?php

use Honed\Registry\Registry;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Registry::serve();
