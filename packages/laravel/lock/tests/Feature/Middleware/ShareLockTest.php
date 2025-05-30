<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Inertia\Testing\AssertableInertia as Assert;
use Workbench\App\Models\User;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);
});

it('shares lock', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has(Lock::getProperty(), fn (Assert $lock) => $lock
            ->where('view', true)
            ->where('edit', false)
        )
        ->etc()
    );
});

it('shares lock with a user', function () {
    Lock::shouldAppend(true);

    $user = User::factory()->create();

    get(route('user.show', $user))->assertInertia(fn (Assert $page) => $page
        ->has(Lock::getProperty(), 2)
        ->has('user', fn (Assert $user) => $user
            ->has(Lock::getProperty(), fn (Assert $lock) => $lock
                ->where('viewAny', true)
                ->where('view', false)
                ->where('create', true)
                ->where('update', true)
                ->where('delete', false)
                ->where('restore', true)
            )->etc()
        )->etc()
    );
})->skip();
