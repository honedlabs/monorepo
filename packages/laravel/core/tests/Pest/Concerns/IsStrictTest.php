<?php

use Honed\Core\Tests\Stubs\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set strict', function () {
    $this->component->setStrict(true);
    expect($this->component->isStrict())->toBeTrue();
});

it('prevents null values', function () {
    $this->component->setStrict(null);
    expect($this->component->isStrict())->toBeFalse();
});

it('can set closure strict', function () {
    $this->component->setStrict(fn () => true);
    expect($this->component->isStrict())->toBeTrue();
});

it('stricts to false', function () {
    expect($this->component->isStrict())->toBeFalse();
});

it('can chain strict', function () {
    expect($this->component->strict(true))->toBeInstanceOf(Component::class);
    expect($this->component->isStrict())->toBeTrue();
});

it('checks if strict', function () {
    expect($this->component->isStrict())->toBeFalse();
    $this->component->setStrict(true);
    expect($this->component->isStrict())->toBeTrue();
});

it('checks if not strict', function () {
    expect($this->component->isNotStrict())->toBeTrue();
    $this->component->setStrict(true);
    expect($this->component->isNotStrict())->toBeFalse();
});
