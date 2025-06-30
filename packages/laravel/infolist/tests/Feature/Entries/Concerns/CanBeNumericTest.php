<?php

declare(strict_types=1);

use Honed\Infolist\Entries\NumericEntry;

beforeEach(function () {
    $this->entry = NumericEntry::make('age');
});

it('does not format null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});

it('does not format by default', function () {
    expect($this->entry)
        ->format(0)->toBe('0')
        ->format(123)->toBe('123');
});

it('does not format non-numeric values', function () {
    expect($this->entry)
        ->format('misc')->toBeNull();
});

it('can divide the number', function () {
    expect($this->entry)
        ->divideBy(10)->toBe($this->entry)
        ->format(100)->toBe('10');
});

it('can format the number as a file size', function () {
    expect($this->entry)
        ->fileSize()->toBe($this->entry)
        ->format(1024)->toBe('1 KB');
});

it('can format the number as a currency', function () {
    expect($this->entry)
        ->currency('USD')->toBe($this->entry)
        ->format(100)->toBe('$100.00');
});

it('can format the number as a number', function () {
    expect($this->entry)
        ->format(100)->toBe('100');
});

it('can format the number with decimals', function () {
    expect($this->entry)
        ->decimals(2)->toBe($this->entry)
        ->format(100)->toBe('100.00');
});

it('can format the number with a locale', function () {
    expect($this->entry)
        ->decimals(2)
        ->locale('fr')->toBe($this->entry)
        ->format(100)->toBe('100,00');
});

it('can format the number as money', function () {
    expect($this->entry)
        ->money('aud', 'en')->toBe($this->entry)
        ->format(100)->toBe('A$100.00');
});
