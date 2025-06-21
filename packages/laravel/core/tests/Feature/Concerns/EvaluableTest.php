<?php

declare(strict_types=1);

use Illuminate\Contracts\Container\BindingResolutionException;
use Workbench\App\Classes\Component;
use Workbench\App\Enums\Status;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = Component::make();
});

it('evaluates a closure', function () {
    expect($this->test)
        ->evaluate(fn () => 'value')->toBe('value');
});

it('evaluates built-ins', function () {
    expect($this->test)
        ->evaluate(1)->toBe(1)
        ->evaluate('value')->toBe('value');
});

it('evaluates enums', function () {
    expect($this->test)
        ->evaluate(Status::Available)->toBe(Status::Available->value);
});

it('evaluates named parameters', function () {
    $fn = fn (int $id, string $prefix) => $prefix.$id;
    expect($this->test)
        ->evaluate($fn, ['id' => 1, 'prefix' => 'value'])->toBe('value1');
});

it('evaluates class-typed parameters', function () {
    $user = User::factory()->create();

    $fn = fn (User $user) => $user->email;

    expect($this->test)
        ->evaluate($fn, [], [User::class => $user])->toBe($user->email);
});

it('evaluates invokable objects', function () {
    $invokable = new class()
    {
        public function __invoke()
        {
            return 'invoked';
        }
    };

    expect($this->test)
        ->evaluate($invokable)->toBe('invoked');
});

it('resolves fallback parameter values', function () {
    $fn = fn (string $name = 'default') => $name;
    expect($this->test)
        ->evaluate($fn)->toBe('default')
        ->evaluate($fn, ['name' => 'value'])->toBe('value');
});

it('resolves default parameter values by type', function () {
    $user = User::factory()->create();

    $fn = fn (User $user) => $user->email;

    expect($this->test)
        ->evaluate($fn)->toBe($user->email);
});

it('resolves default parameter values by name', function () {
    $user = User::factory()->create();

    $fn = fn ($user) => $user->email;

    expect($this->test)
        ->evaluate($fn)->toBe($user->email);
});

it('uses evaluation identifier', function ($callback, $type) {
    expect($this->test)
        ->evaluate($callback)->toBeInstanceOf($type);
})->with([
    [fn (Component $c) => $c, Component::class],
    [fn ($component) => $component, Component::class],
]);

it('fails if it cannot find a binding', function () {
    $fn = fn (Status $status) => $status->name;

    $this->test->evaluate($fn);
})->throws(BindingResolutionException::class);
