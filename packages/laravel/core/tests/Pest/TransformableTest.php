<?php

declare(strict_types=1);

use Honed\Core\Concerns\Transformable;

class TransformableTest
{
    use Transformable;
}

beforeEach(function () {
    $this->test = new class {
        use Transformable;
    };

    $this->fn = fn ($v) => $v * 2;
});

it('accesses', function () {
    expect($this->test)
        ->defineTransformer()->toBeNull()
        ->getTransformer()->toBeNull()
        ->transforms()->toBeFalse()
        ->transformer($this->fn)->toBe($this->test)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->transforms()->toBeTrue();
});

it('transforms', function () {
    expect($this->test)
        ->transform(2)->toBe(2)
        ->transformer($this->fn)->toBe($this->test)
        ->transform(2)->toBe(4);
});

it('defines', function () {
    $test = new class {
        use Transformable;

        public function defineTransformer()
        {
            return fn ($v) => $v * 2;
        }
    };

    expect($test)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->transforms()->toBeTrue()
        ->transform(2)->toBe(4);
});

