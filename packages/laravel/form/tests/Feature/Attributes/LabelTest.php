<?php

declare(strict_types=1);

use Honed\Form\Attributes\Label;
use Honed\Form\Support\Trans;

beforeEach(function () {});

it('has attribute', function (mixed $label, string $expected) {
    $attribute = new Label($label);

    expect($attribute)
        ->toBeInstanceOf(Label::class)
        ->getLabel()->toBe($expected);
})->with([
    fn () => ['Name', 'Name'],
    fn () => [new Trans('Name'), __('Name')],
]);
