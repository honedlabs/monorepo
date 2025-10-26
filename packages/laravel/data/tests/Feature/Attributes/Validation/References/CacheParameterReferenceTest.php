<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\References\CacheParameterReference;
use Honed\Data\Attributes\Validation\References\SessionParameterReference;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->freezeTime();

    $this->data = new class extends Data
    {
        #[Max(new CacheParameterReference('max', 10))]
        public int $value;
    };
})->only();


afterEach(function () {
    cache()->flush();
});

it('gets parameter from cache', function (int $input, bool $expected) {
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
        cache()->rememberForever('max', fn () => 5);

        return [6, false];
    },
    function () {
        cache()->remember('max', 10, fn () => 5);
        cache()->forget('max');

        return [6, true];
    },
    function () {
        cache()->remember('max', 10, fn () => 5);

        $this->travel(9)->seconds();

        return [6, false];
    },
    function () {
        cache()->remember('max', 10, fn () => 5);

        $this->travel(11)->seconds();

        return [6, true];
    },
    function () {
        if (! method_exists(cache()->driver(), 'flexible')) {
            return [10, true];
        }

        cache()->flexible('max', [10, 20], 10);

        $this->travel(11)->seconds();

        cache()->flexible('max', [10, 20], 5);

        defer()->invoke();

        return [6, false];
    }
]);