<?php

use Illuminate\Support\Facades\Route;

use function Orchestra\Testbench\workbench_path;
use function Pest\Laravel\get;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Support\Arr;


beforeEach(function () {
    $this->english = require workbench_path('resources/lang/en/auth.php');
    $this->spanish = require workbench_path('resources/lang/es/auth.php');
});

it('has route macro', function () {
    expect(Route::hasMacro('localize'))->toBeTrue();
});

it('routes for valid locale', function () {
    get('/en/users')->assertInertia(fn (Assert $page) => $page
        ->has('_lang', fn (Assert $page) => $page
            ->has('auth', fn (Assert $page) => $page
                ->where('login', Arr::get($this->english, 'login'))
            )
        )
    );
});

it('routes for valid locale and sets locale', function () {
    get('/es/users')->assertInertia(fn (Assert $page) => $page
        ->has('_lang', fn (Assert $page) => $page
            ->has('auth', fn (Assert $page) => $page
                ->where('login', Arr::get($this->spanish, 'login'))
            )
        )
    );
});

it('throws 404 for invalid locale', function () {
    get('/fr/users')->assertNotFound();
});
