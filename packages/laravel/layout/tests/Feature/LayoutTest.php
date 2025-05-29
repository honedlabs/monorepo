<?php

declare(strict_types=1);

use Honed\Layout\ResponseFactory;
use Honed\Layout\Testing\AssertableInertia as Assert;
use Inertia\Inertia;

use function Pest\Laravel\get;

it('extends response factory', function () {
    expect(Inertia::getFacadeRoot())
        ->toBeInstanceof(ResponseFactory::class);
});

it('sends to response', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->layout('AppLayout')
    );
});
