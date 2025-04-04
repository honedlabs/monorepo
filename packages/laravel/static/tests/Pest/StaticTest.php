<?php

declare(strict_types=1);

use Honed\Pages\PagesRouter;
use Honed\Pages\Facades\Pages;
use Illuminate\Support\Facades\Route;

it('tests', function () {
    // $router->routes();
    dd(Pages::create(\realpath('tests/Stubs/js/Pages')));

    // dd(Route::getRoutes());
});
