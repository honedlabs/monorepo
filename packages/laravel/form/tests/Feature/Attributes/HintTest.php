<?php

declare(strict_types=1);

use Honed\Form\Attributes\Hint;
use Honed\Form\Support\Trans;

beforeEach(function () {});

it('has attribute', function (mixed $hint, string $expected) {
    $attribute = new Hint($hint);

    expect($attribute)
        ->toBeInstanceOf(Hint::class)
        ->getHint()->toBe($expected);
})->with([
    fn () => ['A hint', 'A hint'],
    fn () => [new Trans('hint'), __('hint')],
]);
