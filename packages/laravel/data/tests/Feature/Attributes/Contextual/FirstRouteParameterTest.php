<?php

declare(strict_types=1);

use App\Classes\ModelClass;
use Illuminate\Http\Request;

beforeEach(function () {})->skip();

it('resolves the first route parameter', function () {
    // Request::create('')
    dd(app()->make(ModelClass::class));
});