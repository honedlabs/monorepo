<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->builder = Product::query();
});

it('scopes the query to only include disabled models from boolean', function () {
    expect($this->builder->disabled())
        ->toBeInstanceOf(Builder::class)
        ->getQuery()
        ->scoped(fn ($query) => $query
            ->wheres
            ->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}
                ->scoped(fn ($where) => $where
                    ->toBeArray()
                    ->toHaveCount(5)
                    ->toHaveKeys(['type', 'column', 'operator', 'value', 'boolean'])
                    ->{'type'}->toBe('Basic')
                    ->{'column'}->toBe($this->builder->qualifyColumn($this->builder->getModel()->getDisabledColumn()))
                    ->{'operator'}->toBe('=')
                    ->{'value'}->toBe(true)
                    ->{'boolean'}->toBe('and')
                )
            )
        );
});

it('scopes the query to only include disabled models from timestamp', function () {
    config([
        'disable.boolean' => false,
    ]);

    expect($this->builder->disabled())
        ->toBeInstanceOf(Builder::class)
        ->getQuery()
        ->scoped(fn ($query) => $query
            ->wheres
            ->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}
                ->scoped(fn ($where) => $where
                    ->toBeArray()
                    ->toHaveCount(3)
                    ->toHaveKeys(['type', 'column', 'boolean'])
                    ->{'type'}->toBe('NotNull')
                    ->{'column'}->toBe($this->builder->qualifyColumn($this->builder->getModel()->getDisabledAtColumn()))
                    ->{'boolean'}->toBe('and')
                )
            )
        );
});

it('scopes the query to only include disabled models from user', function () {
    config([
        'disable.boolean' => false,
        'disable.timestamp' => false,
    ]);

    expect($this->builder->disabled())
        ->toBeInstanceOf(Builder::class)
        ->getQuery()
        ->scoped(fn ($query) => $query
            ->wheres
            ->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}
                ->scoped(fn ($where) => $where
                    ->toBeArray()
                    ->toHaveCount(3)
                    ->toHaveKeys(['type', 'column', 'boolean'])
                    ->{'type'}->toBe('NotNull')
                    ->{'column'}->toBe($this->builder->qualifyColumn($this->builder->getModel()->getDisabledByColumn()))
                    ->{'boolean'}->toBe('and')
                )
            )
        );
});

it('scopes the query to only include enabled models from boolean', function () {
    expect($this->builder->enabled())
        ->toBeInstanceOf(Builder::class)
        ->getQuery()
        ->scoped(fn ($query) => $query
            ->wheres
            ->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}
                ->scoped(fn ($where) => $where
                    ->toBeArray()
                    ->toHaveCount(5)
                    ->toHaveKeys(['type', 'column', 'operator', 'value', 'boolean'])
                    ->{'type'}->toBe('Basic')
                    ->{'column'}->toBe($this->builder->qualifyColumn($this->builder->getModel()->getDisabledColumn()))
                    ->{'operator'}->toBe('=')
                    ->{'value'}->toBe(false)
                    ->{'boolean'}->toBe('and')
                )
            )
        );
});

it('scopes the query to only include enabled models from timestamp', function () {
    config([
        'disable.boolean' => false,
    ]);

    expect($this->builder->enabled())
        ->toBeInstanceOf(Builder::class)
        ->getQuery()
        ->scoped(fn ($query) => $query
            ->wheres
            ->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}
                ->scoped(fn ($where) => $where
                    ->toBeArray()
                    ->toHaveCount(3)
                    ->toHaveKeys(['type', 'column', 'boolean'])
                    ->{'type'}->toBe('Null')
                    ->{'column'}->toBe($this->builder->qualifyColumn($this->builder->getModel()->getDisabledAtColumn()))
                    ->{'boolean'}->toBe('and')
                )
            )
        );
});

it('scopes the query to only include enabled models from user', function () {
    config([
        'disable.boolean' => false,
        'disable.timestamp' => false,
    ]);

    expect($this->builder->enabled())
        ->toBeInstanceOf(Builder::class)
        ->getQuery()
        ->scoped(fn ($query) => $query
            ->wheres
            ->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}
                ->scoped(fn ($where) => $where
                    ->toBeArray()
                    ->toHaveCount(3)
                    ->toHaveKeys(['type', 'column', 'boolean'])
                    ->{'type'}->toBe('Null')
                    ->{'column'}->toBe($this->builder->qualifyColumn($this->builder->getModel()->getDisabledByColumn()))
                    ->{'boolean'}->toBe('and')
                )
            )
        );
});