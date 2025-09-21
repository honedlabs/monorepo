<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Honed\Author\Scopes\CreatedByScope;
use Honed\Author\Support\Author;

beforeEach(function () {
    $this->actingAs(User::factory()->create());

    Product::addGlobalScope(new CreatedByScope());

    $this->builder = Product::query();
});

it('applies scope to the builder', function () {
    expect($this->builder->applyScopes())
        ->getQuery()
        ->scoped(fn ($query) => $query
            ->wheres
            ->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(2)
                ->{0}
                ->scoped(fn ($where) => $where
                    ->toBeArray()
                    ->toHaveCount(5)
                    ->toHaveKeys(['type', 'column', 'operator', 'value', 'boolean'])
                    ->{'type'}->toBe('Basic')
                    ->{'column'}->toBe($this->builder->getModel()->getQualifiedCreatedByColumn())
                    ->{'operator'}->toBe('=')
                    ->{'value'}->toBe(Author::identifier())
                    ->{'boolean'}->toBe('and')
                )
            )
        );
});