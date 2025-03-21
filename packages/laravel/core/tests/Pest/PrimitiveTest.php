<?php

declare(strict_types=1);

use Honed\Core\Primitive;
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

it('serializes with removals', function () {
    expect($this->test->jsonSerialize())->toEqual([
        'type' => 'column',
        'name' => 'Products',
    ]);
});

it('is macroable', function () {
    $this->test->macro('test', function () {
        return 'test';
    });

    expect($this->test->test())->toBe('test');
});