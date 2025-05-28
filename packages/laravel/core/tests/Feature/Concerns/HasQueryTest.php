<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasQuery;
use Honed\Core\Contracts\WithQuery;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasQuery;
    };
});

it('sets', function () {
    expect($this->test)
        ->getQuery()->toBeNull()
        ->hasQuery()->toBeFalse()
        ->query(fn () => null)->toBe($this->test)
        ->getQuery()->toBeInstanceOf(Closure::class)
        ->hasQuery()->toBeTrue();
});

it('has contract', function () {
    $test = new class() implements WithQuery
    {
        use Evaluable, HasQuery;

        public function queryUsing($builder)
        {
            return $builder->where('id', 1);
        }
    };

    expect($test)
        ->hasQuery()->toBeTrue()
        ->getQuery()->toBeInstanceOf(Closure::class);
});

it('modifies', function () {
    $builder = User::query();

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
