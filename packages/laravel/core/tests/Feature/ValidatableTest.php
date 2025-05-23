<?php

declare(strict_types=1);

use Honed\Core\Concerns\Validatable;
use Honed\Core\Tests\Stubs\Product;

beforeEach(function () {
    $this->test = new class {
        use Validatable;
    };

    $this->fn = fn (Product $product) => $product->id > 100;
});

it('accesses', function () {
    expect($this->test)
        ->defineValidator()->toBeNull()
        ->validates()->toBeFalse()
        ->getValidator()->toBeNull()
        ->validator($this->fn)->toBe($this->test)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->validates()->toBeTrue();
});

it('validates', function () {
    $product = product();

    expect($this->test)
        ->validate($product)->toBeTrue()
        ->validator($this->fn)->toBe($this->test)
        ->validate($product)->toBeFalse();
});

it('defines', function () {
    $test = new class {
        use Validatable;

        public function defineValidator()
        {
            return fn (Product $product) => $product->id === 1;
        }
    };

    expect($test)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->validates()->toBeTrue()
        ->validate(product())->toBeTrue();
});

