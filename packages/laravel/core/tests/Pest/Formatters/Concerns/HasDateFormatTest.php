<?php

use Honed\Core\Formatters\DateFormatter;

beforeEach(function () {
    $this->formatter = DateFormatter::make();
});

it('has a default date format', function () {
    expect($this->formatter->getDateFormat())->toBe(DateFormatter::DefaultDateFormat);
});

it('can set a date format', function () {
    expect($this->formatter->dateFormat('d M Y'))->toBeInstanceOf(DateFormatter::class)
        ->getDateFormat()->toBe('d M Y');
});

it('can be set using setter', function () {
    $this->formatter->setDateFormat('d M Y');
    expect($this->formatter->getDateFormat())->toBe('d M Y');
});

it('does not accept null values', function () {
    $this->formatter->setDateFormat('d M Y');
    $this->formatter->setDateFormat(null);
    expect($this->formatter->getDateFormat())->toBe('d M Y');
});

it('has shorthand for d M Y', function () {
    expect($this->formatter->dMY())->toBeInstanceOf(DateFormatter::class)
        ->getDateFormat()->toBe('d/M/Y');
});

it('has shorthand for Y-m-d', function () {
    expect($this->formatter->Ymd())->toBeInstanceOf(DateFormatter::class)
        ->getDateFormat()->toBe('Y-m-d');
});

it('has delimiters for shorthand functions', function () {
    expect($this->formatter->dMY('~'))->toBeInstanceOf(DateFormatter::class)
        ->getDateFormat()->toBe('d~M~Y');
});
