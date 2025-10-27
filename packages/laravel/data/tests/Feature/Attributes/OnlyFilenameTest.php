<?php

declare(strict_types=1);

use Honed\Data\Attributes\OnlyFilename;
use Honed\Data\Data\FormData;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->data = new class() extends FormData
    {
        #[OnlyFilename]
        public string $value;
    };
});

it('Segments value', function ($value, $expected) {
    $request = Request::create('/', Request::METHOD_POST, [
        'value' => $value,
    ]);

    expect($this->data::from($request)->value)
        ->toBe($expected);
})->with([
    ['abc.txt', 'abc.txt'],
    ['folder/abc.txt', 'abc.txt'],
    ['folder/abc', 'abc'],
    ['folder/abc.txt.pdf', 'abc.txt.pdf'],
    [5, '5'],
]);

it('throws exceptions', function (mixed $value) {
    $request = Request::create('/', Request::METHOD_POST, [
        'value' => $value,
    ]);

    $this->data::from($request);

    $this->data->value;
})->with([
    fn () => [[]],
    fn () => [new stdClass()],
])->throws(ValidationException::class);
