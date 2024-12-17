<?php

use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

// it('can retrieve the crumb from the class', function () {
//     $response = get(route('product.index'));
//     expect($response->assertInertia(fn (Assert $page) => $page->has('crumbs')
//         ->count('crumbs', 2)
//         ->where('crumbs.0', [
//             'name' => 'Home',
//             'url' => '/',
//         ])
//         ->where('crumbs.1', [
//             'name' => 'Products',
//             'url' => '/products',
//         ])));
// });

// it('can retrieve the crumb from the method', function () {
//     $product = product();

//     $response = get(route('product.show', $product));

//     expect($response->assertInertia(fn (Assert $page) => $page->has('crumbs')
//         ->count('crumbs', 3)
//         ->where('crumbs.0', [
//             'name' => 'Home',
//             'url' => '/',
//         ])
//         ->where('crumbs.1', [
//             'name' => 'Products',
//             'url' => '/products',
//         ])
//         ->where('crumbs.2', [
//             'name' => $product->name,
//             'url' => route('product.show', $product),
//         ])));
// });

// it('is empty if no crumb is set', function () {
//     $response = get('/');
//     expect($response->assertInertia(fn (Assert $page) => $page->missing('crumbs')));
// });
