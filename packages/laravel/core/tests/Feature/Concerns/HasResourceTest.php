<?php

use Honed\Core\Concerns\HasResource;
use Honed\Core\Exceptions\InvalidResourceException;
use Honed\Core\Exceptions\ResourceNotSetException;
use Illuminate\Database\Eloquent\Builder;
use Workbench\App\Enums\Status;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use HasResource;
    };

    $this->builder = User::query();
});

it('sets', function () {
    expect($this->test)
        ->withResource(User::query())->toBe($this->test)
        ->getResource()->toBeInstanceOf(Builder::class)
        ->hasResource()->toBeTrue();
});

it('defines', function () {
    $test = new class()
    {
        use HasResource;

        public function resource()
        {
            return User::query();
        }
    };

    expect($test)
        ->hasResource()->toBeTrue()
        ->getResource()->toBeInstanceOf(Builder::class);
});

it('requires builder', function () {
    $this->test->getResource();
})->throws(ResourceNotSetException::class);

it('converts to builder', function () {
    expect($this->test->throughBuilder(User::query()))
        ->toBeInstanceOf(Builder::class);

    expect($this->test->throughBuilder(User::class))
        ->toBeInstanceOf(Builder::class);

    expect($this->test->throughBuilder(User::factory()->create()))
        ->toBeInstanceOf(Builder::class);
});

it('cannot create without a valid builder', function () {
    $this->test->throughBuilder(Status::cases());
})->throws(InvalidResourceException::class);
