<?php

declare(strict_types=1);

use Honed\Layout\Response;
use Honed\Layout\ResponseFactory;
use Illuminate\Support\Facades\App;
use Inertia\ResponseFactory as InertiaResponseFactory;

it('has response factory', function () {
    expect(App::make(InertiaResponseFactory::class))
        ->toBeInstanceOf(ResponseFactory::class)
        ->render('Index', ['name' => 'Joshua'])->toBeInstanceOf(Response::class)
        ->render('Index', collect(['name' => 'Joshua']))->toBeInstanceOf(Response::class);
});
