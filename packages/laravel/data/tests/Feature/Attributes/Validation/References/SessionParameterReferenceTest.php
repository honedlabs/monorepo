<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\References\SessionParameterReference;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class extends Data
    {
        #[Max(new SessionParameterReference('max', 10))]
        public int $value;
    };
});

it('gets parameter from session', function (int $input, bool $expected) {
    $request = Request::create('/', Request::METHOD_POST, [
        'value' => $input,
    ]);

    if ($expected) {
        expect($this->data::from($request)->value)->toBe($input);
    } else {
        expect(fn () => $this->data::from($request))
            ->toThrow(ValidationException::class);
    }
})->with([
    function () {
        return [10, true];
    },
    function () {
        return [11, false];
    },
    function () {
        session()->put('max', 5);

        return [6, false];
    }
]);
