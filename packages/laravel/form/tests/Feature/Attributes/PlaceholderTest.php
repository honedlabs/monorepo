<?php

declare(strict_types=1);

use Honed\Form\Attributes\Placeholder;
use Honed\Form\Support\Trans;

beforeEach(function () {});

it('has attribute', function (mixed $placeholder, string $expected) {
    $attribute = new Placeholder($placeholder);

    expect($attribute)
        ->toBeInstanceOf(Placeholder::class)
        ->getPlaceholder()->toBe($expected);
})->with([
    fn () => ['Placeholder', 'Placeholder'],
    fn () => [new Trans('placeholder'), __('placeholder')],
]);
