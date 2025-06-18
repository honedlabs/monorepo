<?php

declare(strict_types=1);

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
        ->resource(User::query())->toBe($this->test)
        ->getBuilder()->toBeInstanceOf(Builder::class)
        ->getModel()->toBeInstanceOf(User::class)
        ->for(User::class)->toBe($this->test)
        ->getBuilder()->toBeInstanceOf(Builder::class)
        ->getModel()->toBeInstanceOf(User::class)
        ->for(User::factory()->create())->toBe($this->test)
        ->getBuilder()->toBeInstanceOf(Builder::class)
        ->getModel()->toBeInstanceOf(User::class);
});

it('requires builder', function () {
    $this->test->getBuilder();
})->throws(ResourceNotSetException::class);

it('requires a valid resource', function () {
    $this->test->resource(Status::cases());
})->throws(InvalidResourceException::class);
