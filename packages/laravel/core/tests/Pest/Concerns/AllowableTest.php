<?php

declare(strict_types=1);

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;

class AllowableTest
{
    use Allowable;
    use Evaluable;
}

beforeEach(function () {
    $this->test = new AllowableTest;
});

it('allows by default', function () {
    expect($this->test)
        ->allows()->toBeTrue();
});

it('sets', function () {
    expect($this->test->allow(false))
        ->toBeInstanceOf(AllowableTest::class)
        ->allows()->toBeFalse();
});

it('allows', function () {
    expect($this->test->allow(fn (Product $product) => $product->id > 100))
        ->allows(['product' => product()])->toBeFalse();
});

it('allows models', function () {
    expect($this->test->allow(fn (Product $product) => $product->id > 100))
        ->allows(product())->toBeFalse();
});
