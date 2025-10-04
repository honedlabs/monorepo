<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\NumericFormatter;

beforeEach(function () {
    $this->entry = new NumericFormatter();
});

it('is file', function () {
    expect($this->entry)
        ->isFile()->toBeFalse()
        ->file()->toBe($this->entry)
        ->isFile()->toBeTrue();
});

it('handles null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});

it('handles non-numeric values', function () {
    expect($this->entry)
        ->format('misc')->toBeNull();
});

it('formats numerics', function () {
    expect($this->entry)
        ->format(123)->toBe('123')
        ->format(123.45)->toBe('123.45');
});

it('formats decimals', function () {
    expect($this->entry)
        ->decimals(2)->toBe($this->entry)
        ->format(123)->toBe('123.00')
        ->format(123.455)->toBe('123.46');
});

it('formats files', function () {
    expect($this->entry)
        ->file()->toBe($this->entry)
        ->format(1024)->toBe('1 KB');
});

it('formats locales', function () {
    expect($this->entry)
        ->locale('fr')->toBe($this->entry)
        ->decimals(2)->toBe($this->entry)
        ->format(123)->toBe('123,00')
        ->format(123.45)->toBe('123,45');
});
