<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Memo\MemoGate;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('binds', function () {
    expect(Gate::getFacadeRoot())->toBeInstanceOf(MemoGate::class);
});

it('memoizes', function () {
    expect(Gate::allows('even'))->toBeFalse();
    expect(Gate::allows('even'))->toBeFalse();
    expect(fn () => Gate::authorize('even'))->toThrow(AuthorizationException::class);
});