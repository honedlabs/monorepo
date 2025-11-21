<?php

declare(strict_types=1);

use Honed\Form\Attributes\ClassName;

beforeEach(function () {});

it('has attribute', function (mixed $hint, mixed $expected) {
    $attribute = new ClassName($hint);

    expect($attribute)
        ->toBeInstanceOf(ClassName::class)
        ->getValue()->toBe($expected);
})->with([
    fn () => ['bg-red-500 text-white', 'bg-red-500 text-white'],
]);
