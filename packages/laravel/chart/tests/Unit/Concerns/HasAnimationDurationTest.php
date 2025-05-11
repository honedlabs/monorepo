<?php

declare(strict_types=1);

use Honed\Chart\Concerns\HasAnimationDuration;

beforeEach(function () {
    $this->class = new class {
        use HasAnimationDuration;
    };

    $this->class::flushAnimationDurationState();
});

it('is null by default', function () {
    expect($this->class)
        ->getDuration()->toBeNull();
});

it('can be set', function () {
    expect($this->class)
        ->duration(100)->toBe($this->class)
        ->getDuration()->toBe(100);
});

it('can be set with a global default', function () {
    $this->class::useDuration(100);

    expect($this->class)
        ->getDuration()->toBe(100);
});

it('has array representation', function () {
    expect($this->class->animationDurationToArray())
        ->toBeArray()
        ->toHaveKey('duration');
});

