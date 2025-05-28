<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasRoute;
use Honed\Core\Exceptions\InvalidMethodException;
use Symfony\Component\HttpFoundation\Request;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasRoute;
    };

    $this->user = User::factory()->create();
});

it('sets route', function () {
    expect($this->test)
        ->hasRoute()->toBeFalse()
        ->getRoute()->toBeNull()
        ->route('users.show', $this->user)->toBe($this->test)
        ->hasRoute()->toBeTrue()
        ->getRoute()->toBe(route('users.show', $this->user));
});

it('evaluates route', function () {
    expect($this->test)
        ->route(fn (User $user) => route('users.show', $user))->toBe($this->test)
        ->getRoute(['user' => $this->user])->toBe(route('users.show', $this->user));
});

it('binds route', function () {
    expect($this->test)
        // Will always be bound as model
        ->route('users.show', '{model}')->toBe($this->test)
        ->getRoute(['model' => $this->user])->toBe(route('users.show', $this->user));
});

it('sets url', function () {
    expect($this->test)
        ->hasRoute()->toBeFalse()
        ->getRoute()->toBeNull()
        ->url('https://example.com')->toBe($this->test)
        ->hasRoute()->toBeTrue()
        ->getRoute()->toBe('https://example.com');
});

it('sets method', function () {
    expect($this->test)
        ->getMethod()->toBe(Request::METHOD_GET)
        ->method(Request::METHOD_POST)->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_POST);
});

it('sets external', function () {
    expect($this->test)
        ->isExternal()->toBeFalse()
        ->external()->toBe($this->test)
        ->isExternal()->toBeTrue();
});

it('validates method', function ($input) {
    $this->test->method($input);
})->throws(InvalidMethodException::class)->with([
    [null],
    ['INVALID'],
]);

it('has array representation', function () {
    expect($this->test)
        ->routeToArray()->toBeNull();

    expect($this->test)
        ->route('users.show', $this->user)->toBe($this->test)
        ->routeToArray()->toBe([
            'url' => route('users.show', $this->user),
            'method' => Request::METHOD_GET,
            'external' => false,
        ]);
});
