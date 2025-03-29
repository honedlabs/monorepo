<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;
use Illuminate\Support\Facades\Request;

it('shares one group', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->layout('AppLayout')
    );
});
