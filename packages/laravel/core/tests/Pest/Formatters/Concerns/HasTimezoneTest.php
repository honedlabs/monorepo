<?php

declare(strict_types=1);

use Honed\Core\Formatters\Concerns\HasTimezone;

class HasTimezoneComponent
{
    use HasTimezone;
}

beforeEach(function () {
    $this->component = new HasTimezoneComponent;
});

it('has no timezone by default', function () {
    expect($this->component)
        ->getTimezone()->toBeNull()
        ->hasTimezone()->toBeFalse();
});

it('sets timezone', function () {
    $this->component->setTimezone(100);
    expect($this->component)
        ->getTimezone()->toBe(100)
        ->hasTimezone()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setTimezone(100);
    $this->component->setTimezone(null);
    expect($this->component)
        ->getTimezone()->toBe(100)
        ->hasTimezone()->toBeTrue();
});

it('chains timezone', function () {
    expect($this->component->timezone(100))->toBeInstanceOf(HasTimezoneComponent::class)
        ->getTimezone()->toBe(100)
        ->hasTimezone()->toBeTrue();
});
