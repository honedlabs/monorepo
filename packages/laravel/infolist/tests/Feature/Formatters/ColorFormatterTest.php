<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\ColorFormatter;

beforeEach(function () {
    $this->entry = new ColorFormatter();
});

it('does not format null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});

it('does not format non-string values', function () {
    expect($this->entry)
        ->format(123)->toBeNull()
        ->format(true)->toBeNull()
        ->format(false)->toBeNull()
        ->format(new stdClass())->toBeNull();
});

it('formats strings', function () {
    expect($this->entry)
        ->format('#000000')->toBe('#000000')
        ->format('000000')->toBe('#000000');
});
