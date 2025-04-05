<?php

declare(strict_types=1);

use Honed\Page\Facades\Page;
use Honed\Page\PageRouter;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

beforeEach(function () {
    Route::clearResolvedInstance('router');

    Page::path(\realpath('tests/Stubs/js/Pages'));

    Page::flushExcept();

    Page::flushOnly();
});

// it('creates routes', function () {
//     Page::create();

//     $gets = Route::getRoutes()->get(Request::METHOD_GET);

//     expect($gets)
//         ->toBeArray()
//         ->toHaveCount(\count(registered()) + 1) // The storage/{path} route
//         ->toHaveKeys(registered());

//     foreach (registered() as $route) {
//         expect($gets[$route])
//             ->toBeInstanceOf(RoutingRoute::class)
//             ->getAction()->scoped(fn ($action) => $action
//                 ->toBeArray()
//                 ->toHaveKey('uses')
//                 ->{'uses'}->toBeInstanceOf(\Closure::class)
//             );
//     }

//     $heads = Route::getRoutes()->get(Request::METHOD_HEAD);

//     expect($heads)
//         ->toBeArray()
//         ->toHaveCount(\count(registered()) + 1) // The storage/{path} route
//         ->toHaveKeys(registered());

//     foreach (registered() as $route) {
//         expect($heads[$route])
//             ->toBeInstanceOf(RoutingRoute::class)
//             ->getAction()->scoped(fn ($action) => $action
//                 ->toBeArray()
//                 ->toHaveKey('uses')
//                 ->{'uses'}->toBeInstanceOf(\Closure::class)
//             );
//     }
// });

// it('creates routes by subdirectory', function () {
//     Page::create('Products');

//     $gets = Route::getRoutes()->get(Request::METHOD_GET);

//     $routes = \array_reduce(
//         registered(),
//         function ($routes, $route) {
//             if ($route !== '/') {
//                 $new = \str_replace('products', '', $route);

//                 if (empty($new)) {
//                     $new = '/';
//                 } else {
//                     $new = ltrim($new, '/');
//                 }

//                 $routes[] = $new;
//             }

//             return $routes;
//         },
//         []
//     );

//     expect($gets)
//         ->toBeArray()
//         ->toHaveCount(\count($routes) + 1); // The storage/{path} route

//     foreach ($routes as $route) {
//         expect($gets[$route])
//             ->toBeInstanceOf(RoutingRoute::class)
//             ->getAction()->scoped(fn ($action) => $action
//                 ->toBeArray()
//                 ->toHaveKey('uses')
//                 ->{'uses'}->toBeInstanceOf(\Closure::class)
//             );
//     }
// });

// it('names routes', function () {

// });

it('excludes patterns', function () {
    expect(Page::getExcept())
        ->toBeArray()
        ->toBeEmpty();
    
    expect(Page::except('Index'))->toBeInstanceOf(PageRouter::class)
        ->getExcept()->toEqual(['Index']);

    Page::create();

    $gets = Route::getRoutes()->get(Request::METHOD_GET);
});

// it('excludes directories', function () {
//     expect(Page::except('/'))->toBeInstanceOf(PageRouter::class)
//         ->getExcept()->toEqual(['/']);

//     Page::create();

//     $gets = Route::getRoutes()->get(Request::METHOD_GET);

//     // dd($gets);

// });

// it('includes patterns', function () {
//     expect(Page::getOnly())
//         ->toBeArray()
//         ->toBeEmpty();

//     expect(Page::only('Index'))->toBeInstanceOf(PageRouter::class)
//         ->getOnly()->toEqual(['Index']);

// });