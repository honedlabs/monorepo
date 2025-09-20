<?php

declare(strict_types=1);

use Honed\Core\Contracts\NullsAsUndefined;
use Workbench\App\Classes\SimpleComponent;

beforeEach(function () {
    $this->test = new SimpleComponent();
});

it('has representation', function () {
    expect($this->test)
        ->toArray()->toEqual([
            'type' => null,
        ]);
});

it('serializes to json', function () {
    expect($this->test)
        ->jsonSerialize()->toEqual($this->test->toArray());
});

it('serializes without null values', function () {
    $test = new class() extends SimpleComponent implements NullsAsUndefined {};

    expect($test)
        ->toArray()->toEqual([])
        ->jsonSerialize()->toEqual([]);
});

it('encodes as json', function () {
    expect($this->test->toJson())
        ->toBeJson()
        ->json()->toEqual($this->test->jsonSerialize());
});
