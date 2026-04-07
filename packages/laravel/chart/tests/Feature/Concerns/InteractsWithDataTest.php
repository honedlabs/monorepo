<?php

declare(strict_types=1);

use Honed\Chart\Chart;

beforeEach(function () {
    $this->chart = Chart::make();
    $this->source = [
        ['day' => 'Mon', 'value' => 10],
        ['day' => 'Tue', 'value' => 20],
    ];
});

it('can set source and keys', function () {
    expect($this->chart)
        ->getSource()->toBeNull()
        ->from($this->source)->toBe($this->chart)
        ->getSource()->toEqual($this->source)
        ->source(null)->toBe($this->chart)
        ->getSource()->toBeNull()
        ->hasCategory()->toBeFalse()
        ->hasValue()->toBeFalse()
        ->category('day')->toBe($this->chart)
        ->getCategory()->toBe('day')
        ->hasCategory()->toBeTrue()
        ->value('value')->toBe($this->chart)
        ->getValue()->toBe('value')
        ->hasValue()->toBeTrue();
});

it('can retrieve plucked values', function () {
    expect($this->chart->retrieve($this->source, 'value'))->toEqual([10, 20])
        ->and($this->chart->retrieve($this->source, null))->toBeNull();
});
