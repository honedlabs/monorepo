<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Inertia\Testing\AssertableInertia as Assert;

use function Orchestra\Testbench\workbench_path;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->auth = require workbench_path('resources/lang/en/auth.php');
    $this->greetings = require workbench_path('resources/lang/en/greetings.php');
});

it('shares translations from controller', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has('_lang', fn (Assert $page) => $page
            ->has('auth', fn (Assert $page) => $page
                ->where('login', Arr::get($this->auth, 'login'))
            )
        )
    );
});

it('shares translations from middleware', function () {
    get('/greetings')->assertInertia(fn (Assert $page) => $page
        ->has('_lang', fn (Assert $page) => $page
            ->has('auth', fn (Assert $page) => $page
                ->where('login', Arr::get($this->auth, 'login'))
            )
            ->has('greetings', fn (Assert $page) => $page
                ->has('greeting', fn (Assert $page) => $page
                    ->where('morning', Arr::get($this->greetings, 'greeting.morning'))
                    ->where('afternoon', Arr::get($this->greetings, 'greeting.afternoon'))
                )
            )
        )
    );
});

it('shares translations from middleware with empty keys', function () {
    get('/empty')->assertInertia(fn (Assert $page) => $page
        ->has('_lang', 0)
    );
});
