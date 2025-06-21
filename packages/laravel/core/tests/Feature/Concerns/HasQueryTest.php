<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasQuery;
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
        ->query(fn () => null)->toBe($this->test)
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
