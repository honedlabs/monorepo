<?php

declare(strict_types=1);

use Honed\Form\Attributes\Hint;

beforeEach(function () {});

it('has attribute', function (mixed $hint, string $expected) {
    $attribute = new Hint($hint);

    expect($attribute)
        ->toBeInstanceOf(Hint::class)
        ->getValue()->toBe($expected);
})->with([
    fn () => ['A hint', __('A hint')],
]);
