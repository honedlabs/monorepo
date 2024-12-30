<?php

use Honed\Core\Tests\Stubs\Component;
use Honed\Core\Tests\Stubs\ConfigurableComponent;

beforeEach(function () {
    $this->ext = ConfigurableComponent::make();
    $this->base = Component::make();
});

it('determines if a class is anonymous', function () {
    expect($this->ext->isAnonymous())->toBeFalse();
    expect($this->ext->isNotAnonymous())->toBeTrue();
    expect($this->base->isAnonymous())->toBeTrue();
    expect($this->base->isNotAnonymous())->toBeFalse();
});
