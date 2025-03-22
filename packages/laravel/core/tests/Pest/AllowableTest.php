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
    $this->test = new class {
        use Allowable, Evaluable;
    };
});

it('accesses', function () {
    expect($this->test)
        ->isAllowed()->toBeTrue()
        ->allow(false)->toBe($this->test)
        ->isAllowed()->toBeFalse()
        ->allow(fn (Product $product) => $product->id > 100)
        ->isAllowed(['product' => product()])->toBeFalse();
});