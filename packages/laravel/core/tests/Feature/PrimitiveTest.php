<?php

declare(strict_types=1);

use Honed\Core\Contracts\NullsAsUndefined;
use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->test = Component::make();
});

it('makes', function () {
    expect(Component::make())->toBeInstanceOf(Component::class)
        ->getName()->toBe('component')
        ->getType()->toBeNull();
});

it('has representation', function () {
    expect($this->test)
        ->toArray()->toEqual([
            'name' => 'component',
            'type' => null,
            'meta' => [],
        ]);
});

it('serializes to json', function () {
    expect($this->test)
        ->jsonSerialize()->toEqual($this->test->toArray());
});

it('serializes without null values', function () {
    $test = new class() extends Component implements NullsAsUndefined {};

    $expected = [
        'name' => 'component',
        'meta' => [],
    ];

    expect($test)
        ->toArray()->toEqual($expected)
        ->jsonSerialize()->toEqual($expected);
});

it('encodes as json', function () {
    expect($this->test->toJson())
        ->toBeJson()
        ->json()->toEqual($this->test->jsonSerialize());
});

it('is macroable', function () {
    $this->test->macro('test', function () {
        return 'test';
    });

    expect($this->test)
        ->test()->toBe('test');
});
