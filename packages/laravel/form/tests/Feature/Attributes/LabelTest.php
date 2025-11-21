<?php

declare(strict_types=1);

use Honed\Form\Attributes\Label;

beforeEach(function () {});

it('has attribute', function (mixed $label, string $expected) {
    $attribute = new Label($label);

    expect($attribute)
        ->toBeInstanceOf(Label::class)
        ->getValue()->toBe($expected);
})->with([
    fn () => ['Name', 'Name'],
]);
