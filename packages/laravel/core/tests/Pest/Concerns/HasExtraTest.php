<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Tests\Stubs\Product;

class ExtraTest
{
    use Evaluable;
    use HasExtra;
}

beforeEach(function () {
    $this->test = new ExtraTest;
});

it('sets', function () {
    expect($this->test->extra(['name' => 'test']))
        ->toBeInstanceOf(ExtraTest::class)
        ->hasExtra()->toBeTrue();
});

it('gets', function () {
    expect($this->test)
        ->getExtra()->scoped(fn ($extra) => $extra
        ->toBeArray()
        ->toBeEmpty()
        )
        ->hasExtra()->toBeFalse();

    expect($this->test->extra(['name' => 'test']))
        ->getExtra()->toEqual(['name' => 'test'])
        ->hasExtra()->toBeTrue();
});

it('evaluates', function () {
    $product = product();
    expect($this->test->extra(fn (Product $product) => ['name' => $product->name]))
        ->getExtra(['product' => $product])->toEqual(['name' => $product->name])
        ->hasExtra()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->extra(fn (Product $product) => ['name' => $product->name]))
        ->getExtra($product)->toEqual(['name' => $product->name])
        ->hasExtra()->toBeTrue();
});
