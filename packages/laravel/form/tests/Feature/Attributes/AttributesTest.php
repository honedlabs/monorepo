<?php

declare(strict_types=1);

use Honed\Form\Attributes\Attributes;
use Honed\Form\Support\Trans;

beforeEach(function () {});

it('has attribute', function (mixed $hint, mixed $expected) {
    $attribute = new Attributes($hint);

    expect($attribute)
        ->toBeInstanceOf(Attributes::class)
        ->getAttributes()->toBe($expected);
})->with([
    fn () => [['test' => 'test'], ['test' => 'test']],
]);
