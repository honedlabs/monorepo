<?php

declare(strict_types=1);

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;

beforeEach(function () {
    $this->test = new class {
        use Allowable, Evaluable;
    };
});

it('accesses', function () {
    expect($this->test)
        ->defineAllow()->toBeNull()
        ->isAllowed()->toBeTrue()
        ->allow(false)->toBe($this->test)
        ->isAllowed()->toBeFalse()
        ->allow(fn (Product $product) => $product->id > 100)
        ->isAllowed(['product' => product()])->toBeFalse();
});

it('defines', function () {
    $test = new class {
        use Allowable, Evaluable;

        public function defineAllow()
        {
            return fn (Product $product) => $product->id === 100;
        }
    };

    expect($test)
        ->defineAllow()->toBeInstanceOf(\Closure::class)
        ->isAllowed(['product' => product()])->toBeTrue();
});
