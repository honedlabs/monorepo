<?php

declare(strict_types=1);

use Honed\Core\Concerns\Transformable;
use Honed\Core\Tests\Stubs\Product;

class TransformableTest
{
    use Transformable;
}

beforeEach(function () {
    $this->test = new TransformableTest;
    $this->fn = fn ($v) => $v * 2;
});

it('does not mutate by default', function () {
    expect($this->test)
        ->transform(2)->toBe(2)
        ->transforms()->toBeFalse();
});

it('sets', function () {
    expect($this->test->transformer($this->fn))
        ->toBeInstanceOf(TransformableTest::class)
        ->transforms()->toBeTrue();
});

it('transforms', function () {
    expect($this->test->transformer($this->fn))
        ->transforms()->toBeTrue()
        ->transform(2)->toBe(4);
});
