<?php

use Honed\Crumb\Crumb;
use function Pest\Laravel\get;
use Honed\Crumb\Tests\Stubs\Product;
use Honed\Crumb\Tests\Stubs\Status;

it('can be instantiated', function () {
    expect(new Crumb('Home', '/'))->toBeInstanceOf(Crumb::class)
        ->getLink()->toBe('/')
        ->getName()->toBe('Home')
        ->hasIcon()->toBeFalse();
});

it('can be made', function () {
    expect(Crumb::make('Home', '/'))->toBeInstanceOf(Crumb::class)
        ->getLink()->toBe('/')
        ->getName()->toBe('Home')
        ->hasIcon()->toBeFalse();
});

it('has array representation', function () {
    expect(Crumb::make('Home', '/'))->toArray()->toEqual([
        'name' => 'Home',
        'url' => '/',
    ]);
});

it('can be made with icon', function () {
    expect(Crumb::make('Home', '/', 'fa-solid fa-house'))->toArray()->toEqual([
        'name' => 'Home',
        'url' => '/',
        'icon' => 'fa-solid fa-house',
    ]);
});

it('can resolve route model binding when retrieving array form', function () {
    $p = product();
    get(route('product.show', $p));
    $crumb = Crumb::make(fn ($product) => $product->name, fn (Product $typed) => route('product.show', $typed));

    expect($crumb->toArray())->toBe([
        'name' => $p->name,
        'url' => route('product.show', $p),
    ]);

});

it('can resolve route enum binding when retrieving array form', function () {
    $e = Status::AVAILABLE;
    get(route('status.show', $e));
    $crumb = Crumb::make(fn ($status) => sprintf('Status: %s', $status->value), fn (Status $typed) => route('status.show', $typed));

    expect($crumb->toArray())->toBe([
        'name' => sprintf('Status: %s', Status::AVAILABLE->value),
        'url' => route('status.show', Status::AVAILABLE),
    ]);
});

it('can resolve other binding when retrieving array form', function () {
    $s = 'test';
    get(route('word.show', $s));

    $crumb = Crumb::make(fn ($word) => sprintf('Given %s', $word), fn ($word) => route('word.show', $word));

    expect($crumb->toArray())->toBe([
        'name' => sprintf('Given %s', $s),
        'url' => route('word.show', $s),
    ]);
});
