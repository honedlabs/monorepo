<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});