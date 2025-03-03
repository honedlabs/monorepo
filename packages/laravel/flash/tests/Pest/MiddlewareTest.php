<?php

declare(strict_types=1);

use Honed\Flash\Support\Parameters;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

it('shares via alias', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::PROP)
        ->where(Parameters::PROP, [
            'message' => 'Hello World',
            'type' => config('flash.type'),
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ])
    );
});

it('shares via middleware', function () {
    get('/show')->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::PROP)
        ->where(Parameters::PROP, [
            'message' => 'Hello World',
            'type' => config('flash.type'),
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ])
    );
});
