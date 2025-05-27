<?php

use Honed\Core\Concerns\Validatable;
use Honed\Core\Tests\Stubs\Product;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class {
        use Validatable;
    };

    $this->fn = fn (Product $product) => $product->id > 100;

    $this->user = User::factory()->create();
});

it('sets', function () {
    expect($this->test)
        ->getValidator()->toBeNull()
        ->validate($this->user)->toBeTrue()
        ->validator(true)->toBe($this->test)
        ->validate($this->user)->toBeTrue()
        ->getValidator()->toBeTrue();
});

it('evaluates', function () {
    expect($this->test)
        ->validate($this->user)->toBeTrue()
        ->validator($this->fn)->toBe($this->test)
        ->validate($this->user)->toBeFalse();
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

