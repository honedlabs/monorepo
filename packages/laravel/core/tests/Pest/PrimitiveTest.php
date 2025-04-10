<?php

declare(strict_types=1);

use Honed\Core\Tests\Fixtures\Column;

beforeEach(function () {
    $this->test = Column::make();
});

it('makes', function () {
    expect(Column::make())->toBeInstanceOf(Column::class)
        ->getType()->toBe('column')
        ->getName()->toBe('Products');
});

it('has array representation', function () {
    expect($this->test->toArray())->toEqual([
        'type' => 'column',
        'name' => 'Products',
        'meta' => [],
    ]);
});

it('serializes', function () {
    expect($this->test->jsonSerialize())->toEqual([
        'type' => 'column',
        'name' => 'Products',
        'meta' => [],
    ]);
});

it('is macroable', function () {
    $this->test->macro('test', function () {
        return 'test';
    });

    expect($this->test->test())->toBe('test');
});

it('excludes properties', function () {
    expect($this->test)
        ->has('meta')->toBeTrue()
        ->has('misc')->toBeTrue()
        ->except('meta')->toBe($this->test)
        ->has('meta')->toBeFalse()
        ->has('misc')->toBeTrue();
});

it('includes properties', function () {
    expect($this->test)
        ->has('meta')->toBeTrue()
        ->has('misc')->toBeTrue()
        ->only('meta')->toBe($this->test)
        ->has('meta')->toBeTrue()
        ->has('misc')->toBeFalse();
});