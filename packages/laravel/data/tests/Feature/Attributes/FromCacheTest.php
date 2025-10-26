<?php

declare(strict_types=1);

use Honed\Data\Attributes\FromCache;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->freezeTime();

    $this->data = new class extends Data
    {
        #[FromCache('value')]
        public mixed $value;
    };
});

afterEach(function () {
    cache()->flush();
});

it('skips if not a request', function () {
    expect($this->data::from(new stdClass())->value)->toBeNull();
});

it('provides parameter', function (mixed $value) {
    $request = Request::create('/', Request::METHOD_POST);

    expect($this->data::from($request)->value)->toBe($value);
})->with([
    function () {
        cache(['value' => 'value']);

        return 'value';
    },
    function () {
        cache(['_value' => 'value']);

        return null;
    },
    function () {
        cache(['value' => 'value']);
        cache()->forget('value');

        return null;
    },
    function () {
        cache()->remember('value', 10, function () {
            return 'value';
        });

        $this->travel(9)->seconds();

        return 'value';
    },
    function () {
        cache()->remember('value', 10, function () {
            return 'value';
        });

        $this->travel(11)->seconds();

        return null;
    }
]);

it('provides parameter with flexible', function () {
    cache()->flexible('value', [10, 20], 'value-1');

    $this->travel(11)->seconds();

    cache()->flexible('value', [10, 20], 'value-2');

    defer()->invoke();

    $request = Request::create('/', Request::METHOD_POST);

    expect($this->data::from($request)->value)->toBe('value-2');

})->skip(fn () => ! method_exists(cache()->driver(), 'flexible'));
