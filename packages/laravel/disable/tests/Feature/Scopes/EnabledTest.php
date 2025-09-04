<?php

declare(strict_types=1);

use App\Models\Product;
use Honed\Disable\Scopes\Enabled;

beforeEach(function () {
    Product::addGlobalScope(new Enabled());

    $this->builder = Product::query();
});

it('applies scope to the builder', function () {
    expect($this->builder->applyScopes())
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
