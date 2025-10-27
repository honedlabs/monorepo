<?php

declare(strict_types=1);

use Honed\Data\Attributes\Segment;
use Honed\Data\Data\FormData;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->data = new class() extends FormData
    {
        #[Segment]
        public array $value;
    };
});

it('Segments value', function (mixed $value, array $expected) {
    $request = Request::create('/', Request::METHOD_POST, [
        'value' => $value,
    ]);

    expect($this->data::from($request)->value)
        ->toBe($expected);
})->with([
    ['a,b', ['a', 'b']],
    ['1,2', ['1', '2']],
    ['abc', ['abc']],
]);

it('throws exceptions', function (mixed $value) {
    $request = Request::create('/', Request::METHOD_POST, [
        'value' => $value,
    ]);

    $this->data::from($request);

    $this->data->value;
})->with([
    fn () => [['a']],
    fn () => [new stdClass()],
])->throws(ValidationException::class);
