<?php

declare(strict_types=1);

use Honed\Option\Concerns\HasOptions;
use Honed\Option\Option;

beforeEach(function () {
    $this->class = new class 
    {
        use HasOptions;
    };

    $this->option = Option::make(1, 'One');
});

it('has options', function () {
    expect($this->class)
        ->hasOptions()->toBeFalse()
        ->missingOptions()->toBeTrue()
        ->getOptions()->toBe([])
        ->options([$this->option])->toBe($this->class)
        ->hasOptions()->toBeTrue()
        ->missingOptions()->toBeFalse()
        ->getOptions()->toBe([$this->option]);
});

it('adds option', function () {
    expect($this->class)
        ->option($this->option)->toBe($this->class)
        ->hasOptions()->toBeTrue()
        ->missingOptions()->toBeFalse()
        ->getOptions()->toBe([$this->option]);
});

it('prepends option', function () {
    expect($this->class)
        ->options([$this->option])
        ->beforeAll($option = Option::make(2, 'Two'))->toBe($this->class)
        ->hasOptions()->toBeTrue()
        ->missingOptions()->toBeFalse()
        ->getOptions()->toBe([$option, $this->option]);
});

it('appends option', function () {
    expect($this->class)
        ->options([$this->option])
        ->afterAll($option = Option::make(2, 'Two'))->toBe($this->class)
        ->hasOptions()->toBeTrue()
        ->missingOptions()->toBeFalse()
        ->getOptions()->toBe([$this->option, $option]);
});

it('gets options array', function () {
    expect($this->class)
        ->options([$this->option])
        ->getOptionsArray()->toBe([$this->option->toArray()]);
});