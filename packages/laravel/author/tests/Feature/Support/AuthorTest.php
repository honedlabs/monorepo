<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Author\Support\Author;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);

    Author::using(null);
});

afterEach(function () {
    Author::using(null);
});

it('gets model', function () {
    expect(Author::model())
        ->toBe(AuthUser::class);
});

it('gets identifier', function () {
    expect(Author::identifier())
        ->toBe($this->user->id);
});

it('gets identifier with custom callback', function () {
    Author::using(fn () => (string) Auth::id());

    expect(Author::identifier())
        ->toBe((string) $this->user->id);
});
