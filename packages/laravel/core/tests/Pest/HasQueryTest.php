<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasQuery;
use Honed\Core\Contracts\DefinesQuery;
use Honed\Core\Tests\Stubs\Product;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->test = new class
    {
        use Evaluable;
        use HasQuery;
    };
});

it('has query closure', function () {
    expect($this->test)
        ->hasQuery()->toBeFalse()
        ->query(fn () => null)->toBe($this->test)
        ->hasQuery()->toBeTrue();
});

it('gets query closure', function () {
    expect($this->test)
        ->getQuery()->toBeNull()
        ->query(fn () => null)->toBe($this->test)
        ->getQuery()->toBeInstanceOf(\Closure::class);
});

it('modifies query', function () {
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

it('has query from method', function () {
    $test = new class implements DefinesQuery
    {
        use Evaluable;
        use HasQuery;

        public function usingQuery(Builder $b, int $value)
        {
            $b->where('id', $value);   
        }
    };

    expect($test)
        ->hasQuery()->toBeTrue()
        ->getQuery()->toBeInstanceOf(\Closure::class);

    $builder = Product::query();
    $test->modifyQuery($builder, ['value' => 1]);

    expect($builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->operator->toBe('=')
            ->column->toBe('id')
            ->value->toBe(1)
        );
});
