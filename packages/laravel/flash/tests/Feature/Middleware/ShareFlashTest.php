<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

it('shares via middleware', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has('flash', fn (Assert $prop) => $prop
            ->where('message', 'Hello World')
            ->where('type', config('flash.type'))
            ->where('title', null)
            ->where('duration', config('flash.duration'))
        )
    );
});
