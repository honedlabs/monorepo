<?php

declare(strict_types=1);

use Honed\Pages\Facades\Pages;
use Honed\Pages\PageRouter;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

beforeEach(function () {
    Route::clearResolvedInstance('router');
    Pages::path(\realpath('tests/Stubs/js/Pages'));
    $this->routes = [
        '/',
        'products',
        'products/all',
        'products/variants',
        'products/variants/{productVariant}',
        'products/{product}',
    ];
});

it('creates routes', function () {
    Pages::create();

    $gets = Route::getRoutes()->get(Request::METHOD_GET);

    expect($gets)
        ->toBeArray()
        ->toHaveCount(\count($this->routes) + 1) // The storage/{path} route
        ->toHaveKeys($this->routes);

    foreach ($this->routes as $route) {
        expect($gets[$route])
            ->toBeInstanceOf(RoutingRoute::class)
            ->getAction()->scoped(fn ($action) => $action
                ->toBeArray()
                ->toHaveKey('uses')
                ->{'uses'}->toBeInstanceOf(\Closure::class)
            );
    }

    $heads = Route::getRoutes()->get(Request::METHOD_HEAD);

    expect($heads)
        ->toBeArray()
        ->toHaveCount(\count($this->routes) + 1) // The storage/{path} route
        ->toHaveKeys($this->routes);

    foreach ($this->routes as $route) {
        expect($heads[$route])
            ->toBeInstanceOf(RoutingRoute::class)
            ->getAction()->scoped(fn ($action) => $action
                ->toBeArray()
                ->toHaveKey('uses')
                ->{'uses'}->toBeInstanceOf(\Closure::class)
            );
    }
});
