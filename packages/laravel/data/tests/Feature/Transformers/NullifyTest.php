<?php

declare(strict_types=1);

use Honed\Data\Data\FormData;
use Honed\Data\Transformers\Nullify;
use Spatie\LaravelData\Attributes\WithTransformer;

beforeEach(function () {
    $this->data = new class() extends FormData
    {
        #[WithTransformer(Nullify::class, 0, 2)]
        public int $value;
    };
})->only();

it('nullifies value when transforming to form data', function ($value, $expected) {
    $data = $this->data::from([
        'value' => $value,
    ]);

    expect($data->value)
        ->toBe($value);

    expect($data->toForm())
        ->toEqual([
            'value' => $expected,
        ]);
})->with([
    [0, null],
    [1, 1],
    [2, null],
    [3, 3],
]);

it('does not nullify when transforming to array', function ($value, $expected) {
    $data = $this->data::from([
        'value' => $value,
    ]);

    expect($data->value)
        ->toBe($value);

    expect($data->toArray())
        ->toEqual([
            'value' => $expected,
        ]);
})->with([
    [0, 0],
    [1, 1],
    [2, 2],
    [3, 3],
]);
