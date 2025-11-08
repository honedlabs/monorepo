<?php

declare(strict_types=1);

use Honed\Form\Exceptions\CannotResolveComponent;

it('throws exception', function () {
    CannotResolveComponent::throw('name');
})->throws(CannotResolveComponent::class);
