<?php

declare(strict_types=1);

use Workbench\App\Models\User;
use function Pest\Laravel\post;

use Honed\Action\Testing\BulkRequest;
use Workbench\App\ActionGroups\UserActions;

beforeEach(function () {
    User::factory()->count(10)->create();

    $this->request = BulkRequest::make()
        ->fill()
        ->for(UserActions::class);
});

it('executes the action', function () {
    $data = $this->request
        ->all()
        ->name('update.description')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertRedirect();

    expect(User::all())
        ->each(fn ($user) => $user
            ->description->toBe('test')
        );
});

it('is 404 for no name match', function () {
    $data = $this->request
        ->all()
        ->name('missing')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('is 404 if the action is not allowed', function () {
    // It's a 404 as the action when retrieved cannot be returned.
    $data = $this->request
        ->all()
        ->name('update.name')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('does not mix action types', function () {
    $data = $this->request
        ->all()
        ->name('create.user.name')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('returns inertia response', function () {
    $data = $this->request
        ->all()
        ->name('price.50')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertInertia();

    expect(User::all())
        ->each(fn ($user) => $user
            ->price->toBe(50)
        );
});

it('applies only to selected records', function () {
    $ids = [1, 2, 3, 4, 5];
    $data = $this->request
        ->only($ids)
        ->name('update.description')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertRedirect();

    expect(User::query()->whereIn('id', $ids)->get())
        ->each(fn ($user) => $user
            ->description->toBe('test')
        );

    expect(User::query()->whereNotIn('id', $ids)->get())
        ->each(fn ($user) => $user
            ->description->not->toBe('test')
        );

});

it('applies all excepted records', function () {
    $ids = [1, 2];

    $data = $this->request
        ->all()
        ->except($ids)
        ->name('update.description')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertRedirect();

    expect(User::query()->whereIn('id', $ids)->get())
        ->each(fn ($user) => $user
            ->description->not->toBe('test')
        );

    expect(User::query()->whereNotIn('id', $ids)->get())
        ->each(fn ($user) => $user
            ->description->toBe('test')
        );
});
