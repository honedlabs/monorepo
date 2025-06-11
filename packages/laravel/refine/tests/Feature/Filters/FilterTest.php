<?php

declare(strict_types=1);

use Honed\Refine\Filters\Filter;
use Workbench\App\Enums\Status;

beforeEach(function () {
    $this->filter = Filter::make('name');
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('filter')
        ->interpretsAs()->toBeNull();
});

it('can be boolean', function () {
    expect($this->filter)
        ->asBoolean()->toBe($this->filter)
        ->interpretsAs()->toBe('boolean');
});

it('can be date', function () {
    expect($this->filter)
        ->asDate()->toBe($this->filter)
        ->interpretsAs()->toBe('date');
});

it('can be date time', function () {
    expect($this->filter)
        ->asDatetime()->toBe($this->filter)
        ->interpretsAs()->toBe('datetime');
});

it('can be float', function () {
    expect($this->filter)
        ->asFloat()->toBe($this->filter)
        ->interpretsAs()->toBe('float');
});

it('can be integer', function () {
    expect($this->filter)
        ->asInt()->toBe($this->filter)
        ->interpretsAs()->toBe('int');
});

it('can be array multiple', function () {
    expect($this->filter)
        ->multiple()->toBe($this->filter)
        ->interpretsAs()->toBe('array')
        ->isMultiple()->toBeTrue();
});

it('can be text', function () {
    expect($this->filter)
        ->asString()->toBe($this->filter)
        ->interpretsAs()->toBe('string');
});

it('can be time', function () {
    expect($this->filter)
        ->asTime()->toBe($this->filter)
        ->interpretsAs()->toBe('time');
});

it('can be presence', function () {
    expect($this->filter)
        ->presence()->toBe($this->filter)
        ->interpretsAs()->toBe('boolean')
        ->isPresence()->toBeTrue();
});

it('has default', function () {
    expect($this->filter)
        ->getDefault()->toBeNull()
        ->default('value')->toBe($this->filter)
        ->getDefault()->toBe('value');
});

it('has enum shorthand', function () {
    expect($this->filter)
        ->hasOptions()->toBeFalse()
        ->enum(Status::class)->toBe($this->filter)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(\count(Status::cases()));
});

it('can be multiple', function () {
    expect($this->filter)
        ->isMultiple()->toBeFalse()
        ->interpretsAs()->toBeNull()
        ->multiple()->toBe($this->filter)
        ->isMultiple()->toBeTrue()
        ->interpretsAs()->toBe('array');
});
