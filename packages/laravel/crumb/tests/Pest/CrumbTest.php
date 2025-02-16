<?php

use Honed\Crumb\Crumb;
use Honed\Crumb\Tests\Stubs\Product;
use Honed\Crumb\Tests\Stubs\Status;

use function Pest\Laravel\get;


it('can be made', function () {
    expect(Crumb::make('Home', 'home'))->toBeInstanceOf(Crumb::class)
        ->getRoute()->toBe(route('home'))
        ->getName()->toBe('Home')
        ->hasIcon()->toBeFalse();
});

it('has array representation', function () {
    expect(Crumb::make('Home', 'home')->toArray())
        ->toEqual([
            'name' => 'Home',
            'url' => route('home'),
            'icon' => null,
        ]);
});

it('can resolve route model binding', function () {
    $p = product();

    get(route('products.show', $p));

    $crumb = Crumb::make(
        fn ($product) => $product->name, 
        fn (Product $typed) => route('products.show', $typed)
    );

    expect($crumb->toArray())->toBe([
        'name' => $p->name,
        'url' => route('products.show', $p),
        'icon' => null,
    ]); 
});
// it('can resolve route enum binding when retrieving array form', function () {
//     $e = Status::AVAILABLE;
//     get(route('status.show', $e));
//     $crumb = Crumb::make(fn ($status) => sprintf('Status: %s', $status->value), fn (Status $typed) => route('status.show', $typed));

//     expect($crumb->toArray())->toBe([
//         'name' => sprintf('Status: %s', Status::AVAILABLE->value),
//         'url' => route('status.show', Status::AVAILABLE),
//     ]);
// });

// it('can resolve other binding when retrieving array form', function () {
//     $s = 'test';
//     get(route('word.show', $s));

//     $crumb = Crumb::make(fn ($word) => sprintf('Given %s', $word), fn ($word) => route('word.show', $word));

//     expect($crumb->toArray())->toBe([
//         'name' => sprintf('Given %s', $s),
//         'url' => route('word.show', $s),
//     ]);
// });
