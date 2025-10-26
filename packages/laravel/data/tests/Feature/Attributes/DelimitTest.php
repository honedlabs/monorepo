<?php

declare(strict_types=1);

use Honed\Data\Attributes\Delimit;
use Honed\Data\Data\FormData;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class extends FormData {
        #[Delimit]
        public string $value;
    };
});

it('delimits value', function (mixed $value, string $expected) {
    $request = Request::create('/', Request::METHOD_POST, [
        'value' => $value
    ]);

    expect($this->data::from($request)->value)
        ->toBe($expected);
})->with([
    [['a', 'b'], 'a,b'],
    [[1, 2], '1,2'],
    ['a', 'a']
]);

it('throws exceptions', function (mixed $value) {
    $request = Request::create('/', Request::METHOD_POST, [
        'value' => $value
    ]);

    $this->data::from($request);

})->with([
    fn () => [[[1], [2]]],
    fn () => [new stdClass],
])->throws(ValidationException::class);