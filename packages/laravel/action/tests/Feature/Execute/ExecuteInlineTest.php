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

it('executes callback', function () {
    $this->test->action(function (User $record) {
        $record->update(['name' => 'test']);

        return inertia('Users/Show', [
            'user' => $record,
        ]);
    });

    expect($this->test->execute($this->user))
        ->toBeInstanceOf(Inertia\Response::class);

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'test',
    ]);
});

it('executes handler', function () {
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

it('executes action', function () {
    expect($this->test->action(DestroyUser::class))
        ->execute($this->user)
        ->toBeInstanceOf(RedirectResponse::class);

    $this->assertDatabaseMissing('users', [
        'id' => $this->user->id,
    ]);
});
