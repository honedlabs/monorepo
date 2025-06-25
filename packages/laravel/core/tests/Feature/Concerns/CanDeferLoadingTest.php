<?php

declare(strict_types=1);

use Inertia\DeferProp;
use Inertia\LazyProp;
use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->component = Component::make();
});

it('can defer loading', function () {
    expect($this->component->deferLoading())
        ->toBeInstanceOf(DeferProp::class);
});

it('can lazy load', function () {
    expect($this->component->lazyLoading())
        ->toBeInstanceOf(LazyProp::class);
});
