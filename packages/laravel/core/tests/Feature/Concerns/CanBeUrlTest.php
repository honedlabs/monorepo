<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanBeUrl;
use Honed\Core\Concerns\Evaluable;
use Symfony\Component\HttpFoundation\Request;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use CanBeUrl, Evaluable;
    };

    $this->user = User::factory()->create();
});

it('sets route', function () {
    expect($this->test)
        ->getUrl()->toBeNull()
        ->hasUrl()->toBeFalse()
        ->url('users.show', $this->user)->toBe($this->test)
        ->getUrl()->toBe(route('users.show', $this->user))
        ->hasUrl()->toBeTrue();
});

it('sets closure', function () {
    expect($this->test)
        ->url(fn (User $user) => url('users.show', $user))->toBe($this->test)
        ->getUrl(['user' => $this->user])->toBe(url('users.show', $this->user));
});

it('sets implicit route url', function () {
    expect($this->test)
        // Will always be bound as model
        ->url('users.show', '{record}')->toBe($this->test)
        ->getUrl(['record' => $this->user])->toBe(route('users.show', $this->user));
});

it('sets uri', function () {
    expect($this->test)
        ->getUrl()->toBeNull()
        ->url('/users')->toBe($this->test)
        ->getUrl()->toBe(url('/users'));
});

it('sets url', function () {
    expect($this->test)
        ->getUrl()->toBeNull()
        ->url('https://example.com')->toBe($this->test)
        ->getUrl()->toBe('https://example.com');
});

it('sets method', function () {
    expect($this->test)
        ->getMethod()->toBe(Request::METHOD_GET)
        ->method(Request::METHOD_POST)->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_POST)
        ->patch()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_PATCH)
        ->put()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_PUT)
        ->delete()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_DELETE)
        ->post()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_POST);
});

it('validates method', function ($input) {
    $this->test->method($input);
})->throws(InvalidArgumentException::class)->with([
    [null],
    ['INVALID'],
]);

it('has array representation', function () {
    expect($this->test)
        ->urlToArray()->toBeNull();

    expect($this->test)
        ->url('users.show', $this->user)->toBe($this->test)
        ->urlToArray()->toBe([
            'url' => route('users.show', $this->user),
            'method' => Request::METHOD_GET,
        ]);
});
