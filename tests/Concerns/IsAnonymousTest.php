<?php

use Workbench\App\Component;
use Workbench\App\ConfigurableComponent;

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
