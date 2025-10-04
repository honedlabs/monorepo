<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\MappedFormatter;

beforeEach(function () {
    $this->formatter = new MappedFormatter();
});

it('has mapping', function () {
    expect($this->formatter)
        ->getMapping()->toBeArray()
        ->mapping(['1' => 'one', '2' => 'two'])->toBe($this->formatter)
        ->getMapping()->toEqual(['1' => 'one', '2' => 'two'])
        ->mapping(fn ($value) => $value * 2)->toBe($this->formatter)
        ->getMapping()->toBeInstanceOf(Closure::class);
});

it('has default', function () {
    expect($this->formatter)
        ->getDefault()->toBeNull()
        ->default('default')->toBe($this->formatter)
        ->getDefault()->toBe('default');
});

it('formats', function () {
    expect($this->formatter)
        ->format(1)->toBeNull()
        ->mapping([1 => 'one', 2 => 'two'])->toBe($this->formatter)
        ->format(1)->toBe('one')
        ->format(3)->toBeNull()
        ->mapping(fn ($value) => $value * 2)->toBe($this->formatter)
        ->format(1)->toBe(2);
});

it('formats with default', function () {
    expect($this->formatter)
        ->default('default')->toBe($this->formatter)
        ->format(1)->toBe('default')
        ->mapping([1 => 'one', 2 => 'two'])->toBe($this->formatter)
        ->format(3)->toBe('default')
        ->mapping(fn ($value) => null)->toBe($this->formatter)
        ->format(1)->toBe('default');
});
