<?php

declare(strict_types=1);

use Honed\Core\Concerns\Transformable;

beforeEach(function () {
    $this->test = new class()
    {
        use Transformable;
    };

    $this->fn = fn ($v) => $v * 2;
});

it('sets', function () {
    expect($this->test)
        ->getTransformer()->toBeNull()
        ->transforms()->toBeFalse()
        ->transformer($this->fn)->toBe($this->test)
        ->getTransformer()->toBeInstanceOf(Closure::class)
        ->transforms()->toBeTrue();
});

it('transforms', function () {
    expect($this->test)
        ->transform(2)->toBe(2)
        ->transformer($this->fn)->toBe($this->test)
        ->transform(2)->toBe(4);
});
