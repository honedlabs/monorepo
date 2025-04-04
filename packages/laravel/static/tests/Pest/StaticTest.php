<?php

declare(strict_types=1);

use Honed\Pages\Facades\Pages;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Pages::path(\realpath('tests/Stubs/js/Pages'));
});

it('tests', function () {
    Pages::create();

    dd(Route::getRoutes());
});
