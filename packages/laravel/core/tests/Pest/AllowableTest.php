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

it('sets', function () {
    expect($this->test->allow(false))
        ->toBeInstanceOf(AllowableTest::class)
        ->isAllowed()->toBeFalse();
});

it('checks', function () {
    expect($this->test)
        ->isAllowed()->toBeTrue();

    expect($this->test->allow(fn (Product $product) => $product->id > 100))
        ->isAllowed(['product' => product()])->toBeFalse();
});
