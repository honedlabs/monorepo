<?php

declare(strict_types=1);

use Workbench\App\Classes\ChildComponent;
use Workbench\App\Classes\Component;

it('lists components', function () {
    $this->artisan('list:components')
        ->expectsOutputToContain(Component::class)
        ->expectsOutputToContain(ChildComponent::class)
        ->assertSuccessful();
});
