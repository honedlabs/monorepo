<?php

declare(strict_types=1);

use Honed\Chart\Concerns\ExcludesFromDomainCalculation;

beforeEach(function () {
    $this->class = new class {
        use ExcludesFromDomainCalculation;
    };

    $this->class::flushExcludeFromDomainCalculationState();
});

it('is null by default', function () {
    expect($this->class)
        ->excludesFromDomain()->toBeNull();
});

it('can be set', function () {
    expect($this->class)
        ->excludeFromDomain()->toBe($this->class)
        ->excludesFromDomain()->toBeTrue();
});

it('can be set with a global default', function () {
    $this->class::shouldExcludeFromDomain(false);

    expect($this->class)
        ->excludesFromDomain()->toBeFalse();
});

it('has array representation', function () {
    expect($this->class->excludeFromDomainToArray())
        ->toBeArray()
        ->toHaveKey('excludeFromDomainCalculation');
});

