<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Workbench\App\Models\User;
use function Pest\Laravel\post;

use Honed\Action\Testing\InlineRequest;
use Workbench\App\ActionGroups\UserActions;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->request = InlineRequest::fake()
        ->for(UserActions::class)
        ->fill();
});

it('executes the action', function () {
    $data = $this->request
        ->record($this->user->id)
        ->name('update.name')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertRedirect();

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'test',
    ]);
});

it('is 404 for no name match', function () {
    $data = $this->request
        ->record($this->user->id)
        ->name('missing')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('is 404 if no model is found', function () {
    $data = $this->request
        ->record(Str::uuid()->toString())
        ->name('update.name')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('is 404 if the action is not allowed', function () {
    // It's a 404 as the action when retrieved cannot be returned.
    $data = $this->request
        ->record($this->user->id)
        ->name('update.description')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('does not mix action types', function () {
    $data = $this->request
        ->record($this->user->id)
        ->name('create.user.name')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('does not execute route actions', function () {
    $data = $this->request
        ->record($this->user->id)
        ->name('show')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertRedirect(); // Returns back
});

it('returns inertia response', function () {
    $data = $this->request
        ->record($this->user->id)
        ->name('price.100')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertInertia();

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'price' => 100,
    ]);
});
