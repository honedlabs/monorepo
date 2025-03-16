<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasQueryClosure;
use Honed\Core\Tests\Stubs\Product;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->test = new class
    {
        use Evaluable;
        use HasQueryClosure;
    };
});

it('has query closure', function () {
    expect($this->test)
        ->hasQueryClosure()->toBeFalse()
        ->queryClosure(fn () => null)->toBe($this->test)
        ->hasQueryClosure()->toBeTrue();
});

it('gets query closure', function () {
    expect($this->test)
        ->getQueryClosure()->toBeNull()
        ->queryClosure(fn () => null)->toBe($this->test)
        ->getQueryClosure()->toBeInstanceOf(\Closure::class);
});

it('modifies query', function () {
    $builder = Product::query();
    $fn = fn ($builder, $value) => $builder->where('id', $value);

    $this->test->modifyQuery($builder, ['value' => 1]);

    expect($builder->getQuery()->wheres)->toBeEmpty();

    $this->test->queryClosure($fn)->modifyQuery($builder, ['value' => 1]);

    expect($builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
        ->operator->toBe('=')
        ->column->toBe('id')
        ->value->toBe(1)
        );
});

it('has query from method', function () {
    $test = new class
    {
        use Evaluable;
        use HasQueryClosure;

        public function query(Builder $b, int $value)
        {
            $b->where('id', $value);
        }
    };

    expect($test)
        ->hasQueryClosure()->toBeTrue()
        ->getQueryClosure()->toBeInstanceOf(\Closure::class);

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
