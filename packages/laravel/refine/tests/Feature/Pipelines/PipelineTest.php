<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Workbench\App\Enums\Status;
use Workbench\App\Refiners\ProductRefiner;

it('basic pipeline test', function () {
    $refine = ProductRefiner::make()
        ->request(Request::create('/', 'GET', [
            'name' => 'test',
            'price' => 100,
            'status' => \sprintf('%s,%s', Status::Available->value, Status::Unavailable->value),
            'only' => Status::ComingSoon->value,
            'favourite' => '1',
            'oldest' => '2000-01-01',
            'newest' => '2001-01-01',
            'sort' => '-price',
            'search' => 'term',
        ]))
        ->refine();

    expect($refine)
        ->isSearching()->toBeTrue()
        ->isFiltering()->toBeTrue()
        ->isSorting()->toBeTrue();

    expect($refine->getResource()->getQuery())
        ->wheres
        ->scoped(fn ($wheres) => $wheres
            ->toBeArray()
            ->toHaveCount(9)
            ->toEqualCanonicalizing([
                [
                    'type' => 'raw',
                    'sql' => 'LOWER(name) LIKE ?',
                    'boolean' => 'and',
                ],
                [
                    'type' => 'raw',
                    'sql' => 'LOWER(description) LIKE ?',
                    'boolean' => 'or',
                ],
                [
                    'type' => 'raw',
                    'sql' => 'LOWER(name) LIKE ?',
                    'boolean' => 'and',
                ],
                [
                    'type' => 'Basic',
                    'column' => 'price',
                    'operator' => '>=',
                    'value' => 100,
                    'boolean' => 'and',
                ],
                [
                    'type' => 'In',
                    'column' => 'status',
                    'values' => [Status::Available->value, Status::Unavailable->value],
                    'boolean' => 'and',
                ],
                [
                    'type' => 'In',
                    'column' => 'status',
                    'values' => [Status::ComingSoon->value],
                    'boolean' => 'and',
                ],
                [
                    'type' => 'Basic',
                    'column' => 'best_seller',
                    'operator' => '=',
                    'value' => true,
                    'boolean' => 'and',
                ],
                [
                    'type' => 'Date',
                    'column' => 'created_at',
                    'boolean' => 'and',
                    'operator' => '>=',
                    'value' => '2000-01-01',
                ],
                [
                    'type' => 'Date',
                    'column' => 'created_at',
                    'boolean' => 'and',
                    'operator' => '<=',
                    'value' => '2001-01-01',
                ],
            ])
        )->orders->toBeOnlyOrder('price', 'desc');
});
