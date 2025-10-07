<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Lang\Facades\Lang;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

use function Orchestra\Testbench\workbench_path;
use function Pest\Laravel\get;

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

it('routes for valid locale and sets it', function () {
    get('/es/users')->assertInertia(fn (Assert $page) => $page
        ->has('_lang', fn (Assert $page) => $page
            ->has('auth', fn (Assert $page) => $page
                ->where('login', Arr::get($this->spanish, 'login'))
            )
        )
    );
});

it('does not set locale if not provided', function () {
    get('/localize')->assertInertia(fn (Assert $page) => $page
        ->has('_lang', fn (Assert $page) => $page
            ->has('auth', fn (Assert $page) => $page
                ->where('login', Arr::get($this->english, 'login'))
            )
        )
    );
});

it('throws 404 for invalid locale', function () {
    get('/fr/users')->assertNotFound();
});

it('injects locale', function () {
    get('/en/injection')->assertSee('en');

    get('/es/injection')->assertSee('es');

    get('/fr/injection')->assertNotFound();
});

it('creates routes without locale', function () {
    Lang::registerParameter();

    expect(route('users.index', absolute: false))->toBe('/en/users');

    expect(route('users.show', 1, absolute: false))->toBe('/en/users/1');

    $user = User::factory()->create();

    expect(route('users.show', $user, absolute: false))->toBe('/en/users/'.$user->getKey());
});
