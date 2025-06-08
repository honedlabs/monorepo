<?php

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\App;

it('tests', function () {
    dd(config('auth'));
    dd(App::make(User::class));
})->only();