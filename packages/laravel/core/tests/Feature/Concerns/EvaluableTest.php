<?php

declare(strict_types=1);

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Workbench\App\Classes\Component;
use Workbench\App\Enums\Status;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->component = Component::make();

    $this->user = User::factory()->create();
});

it('evaluates return types', function ($input, $output) {
    expect($this->component)
        ->evaluate($input)->toBe($output);
})->with([
    'string' => ['string', 'string'],
    'int' => [1, 1],
    'closure' => [fn () => 'value', 'value'],
    'enum' => [Status::Available, Status::Available->value],
    'invokable' => [new class()
    {
        public function __invoke()
        {
            return 'invoked';
        }
    }, 'invoked'],
    'default value' => [fn (string $name = 'default') => $name, 'default'],
    'default by type' => fn () => [fn (User $u) => $u->email, $this->user->email],
    'default by name' => fn () => [fn ($user) => $user->email, $this->user->email],
    'static' => [fn (Component $c) => $c->getName(), 'component'],
    'evaluation identifier' => fn () => [fn ($component) => $component, $this->component],
    'container' => fn () => [fn (Container $container) => $container, app()],
]);

it('evaluates named dependencies', function ($input, $dependencies, $output) {
    expect($this->component)
        ->evaluate($input, named: $dependencies)->toBe($output);
})->with([
    'named' => fn () => [fn (string $name) => $name, ['name' => 'value'], 'value'],
    'optional' => fn () => [fn (string $name = 'default') => $name, ['name' => 'value'], 'value'],
]);

it('evaluates typed dependencies', function ($input, $dependencies, $output) {
    expect($this->component)
        ->evaluate($input, typed: $dependencies)->toBe($output);
})->with([
    'typed' => fn () => [fn (User $user) => $user->email, [User::class => $this->user], $this->user->email],
]);

it('fails if it cannot find a binding', function () {
    $fn = fn (Status $status) => $status->name;

    $this->component->evaluate($fn);
})->throws(BindingResolutionException::class);
