<?php

declare(strict_types=1);

use Honed\Core\Concerns\Validatable;
use Honed\Core\Tests\Stubs\Product;

class ValidatableTest
{
    use Validatable;
}

beforeEach(function () {
    $this->test = new ValidatableTest;
    $this->fn = fn (Product $product) => $product->id > 100;
    $this->product = product();
});

it('passes by default', function () {
    expect($this->test)
        ->validate($this->product)->toBeTrue()
        ->validates()->toBeFalse();
});

it('sets', function () {
    expect($this->test->validator($this->fn))
        ->toBeInstanceOf(ValidatableTest::class)
        ->validates()->toBeTrue();
});

it('validates', function () {
    expect($this->test->validator($this->fn))
        ->validates()->toBeTrue()
        ->validate($this->product)->toBeFalse();
});
