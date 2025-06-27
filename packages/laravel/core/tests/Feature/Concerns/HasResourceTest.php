<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasResource;
use Illuminate\Database\Eloquent\Builder;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use HasResource;
    };
});

it('sets eloquent', function () {
    expect($this->test)
        ->resource(User::query())->toBe($this->test)
        ->getResource()->toBeInstanceOf(Builder::class)
        ->getBuilder()->toBeInstanceOf(Builder::class)
        ->getModel()->toBeInstanceOf(User::class)
        ->for(User::class)->toBe($this->test)
        ->getResource()->toBeInstanceOf(Builder::class)
        ->getBuilder()->toBeInstanceOf(Builder::class)
        ->getModel()->toBeInstanceOf(User::class)
        ->for(User::factory()->create())->toBe($this->test)
        ->getResource()->toBeInstanceOf(Builder::class)
        ->getBuilder()->toBeInstanceOf(Builder::class)
        ->getModel()->toBeInstanceOf(User::class);
});

it('sets arrayable', function () {
    expect($this->test)
        ->resource([['name' => 'test']])->toBe($this->test)
        ->getResource()->toBe([['name' => 'test']])
        ->resource(collect([['name' => 'test']]))->toBe($this->test)
        ->getResource()->toBe([['name' => 'test']]);
});

it('errors if setting invalid resource', function () {
    $this->test->resource(new stdClass());
})->throws(InvalidArgumentException::class);

it('requires builder', function () {
    $this->test->getBuilder();
})->throws(InvalidArgumentException::class);

it('requires a valid resource', function () {
    $this->test->resource([['name' => 'test']])->getBuilder();
})->throws(InvalidArgumentException::class);
