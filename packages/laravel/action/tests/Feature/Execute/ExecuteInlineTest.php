<?php

declare(strict_types=1);

use Honed\Action\Operations\InlineOperation;
use Illuminate\Http\RedirectResponse;
use Workbench\App\Actions\User\DestroyUser;
use Workbench\App\Models\User;
use Workbench\App\Operations\DestroyOperation;

beforeEach(function () {
    $this->test = InlineOperation::make('test');
    $this->user = User::factory()->create();
});

test('not without action', function () {
    expect($this->test->execute($this->user))
        ->toBeNull();

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
    ]);
});

test('with callback', function () {
    $this->test->action(function (User $user) {
        $user->update(['name' => 'test']);

        return inertia('Users/Show', [
            'user' => $user,
        ]);
    });

    expect($this->test->execute($this->user))
        ->toBeInstanceOf(Inertia\Response::class);

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'test',
    ]);
});

test('with handler', function () {
    $action = new DestroyOperation();

    expect($action)
        ->record($this->user)->toBe($action)
        ->getName()->toBe('destroy')
        ->getLabel()->toBe('Destroy '.$this->user->name)
        ->getType()->toBe('inline')
        ->isAction()->toBeTrue();

    $action->execute($this->user);

    $this->assertDatabaseMissing('users', [
        'id' => $this->user->id,
    ]);
})->skip();

test('with class-string action', function () {
    expect($this->test->action(DestroyUser::class))
        ->execute($this->user)
        ->toBeInstanceOf(RedirectResponse::class);

    $this->assertDatabaseMissing('users', [
        'id' => $this->user->id,
    ]);
});
