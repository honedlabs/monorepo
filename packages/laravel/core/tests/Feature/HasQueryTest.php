<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasQuery;
use Honed\Core\Contracts\HasQuery as HasQueryContract;
use Honed\Core\Tests\Stubs\Product;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasQuery;
    };
});

it('accesses', function () {
    expect($this->test)
        ->hasQuery()->toBeFalse()
        ->getQuery()->toBeNull()
        ->query(fn () => null)->toBe($this->test)
        ->hasQuery()->toBeTrue()
        ->getQuery()->toBeInstanceOf(\Closure::class);
});

it('defines', function () {
    $test = new class {
        use Evaluable, HasQuery;

        public function defineQuery()
        {
            return fn ($builder) => $builder->where('id', 1);
        }
    };

    expect($test)
        ->hasQuery()->toBeTrue()
        ->getQuery()->toBeInstanceOf(\Closure::class);
});

it('modifies', function () {
    $builder = Product::query();

    $fn = fn ($builder, $value) => $builder->where('id', $value);

    $this->test->modifyQuery($builder, ['value' => 1]);

    expect($builder->getQuery()->wheres)->toBeEmpty();

    $this->test->query($fn)->modifyQuery($builder, ['value' => 1]);

    expect($builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->operator->toBe('=')
            ->column->toBe('id')
            ->value->toBe(1)
        );
});