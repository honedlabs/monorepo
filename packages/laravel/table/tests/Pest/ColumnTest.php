<?php

use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\NumericFormatter;
use Honed\Core\Formatters\StringFormatter;
use Honed\Table\Columns\BooleanColumn;
use Honed\Table\Columns\Column;
use Honed\Table\Columns\DateColumn;
use Honed\Table\Columns\NumericColumn;
use Honed\Table\Columns\TextColumn;

beforeEach(function () {
    $this->test = Column::make('name');
});

it('applies to a value', function () {
    expect($this->test->apply('value'))->toBe('value');

    expect($this->test->transformer(fn ($value) => $value * 2))
        ->toBeInstanceOf(Column::class)
        ->and($this->test->apply(2))->toBe(4);
});

it('has array representation', function () {
    expect($this->test->toArray())->toEqual([
        'name' => 'name',
        'label' => 'Name',
        'hidden' => false,
        'icon' => null,
        'toggle' => true,
        'active' => true,
        'sort' => null,
        'meta' => [],
        'class' => null,
    ]);
});

it('has formatters', function () {
    expect($this->test->hasFormatter())->toBeFalse();

    expect(BooleanColumn::make('name'))
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(BooleanFormatter::class);

    expect(TextColumn::make('name'))
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(StringFormatter::class);

    expect(NumericColumn::make('name'))
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(NumericFormatter::class);

    expect(DateColumn::make('name'))
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('can be sortable', function () {
    expect($this->test->sortable())
        ->toBeInstanceOf(Column::class)
        ->isSortable()->toBeTrue()
        ->toArray()->toEqual([
            'name' => 'name',
            'label' => 'Name',
            'hidden' => false,
            'icon' => null,
            'toggle' => true,
            'active' => true,
            'sort' => [
                'direction' => null,
                'next' => 'name',
            ],
            'class' => null,
            'meta' => [],
        ]);
});

it('can be toggleable', function () {
    expect($this->test)
        ->sometimes()->toBeInstanceOf(Column::class)
        ->isSometimes()->toBeTrue()
        ->isToggleable()->toBeTrue()
        ->toArray()->toEqual([
            'name' => 'name',
            'label' => 'Name',
            'hidden' => false,
            'icon' => null,
            'toggle' => true,
            'active' => true,
            'class' => null,
            'sort' => null,
            'meta' => [],
        ])
        ->always()->toBeInstanceOf(Column::class)
        ->isToggleable()->toBeFalse()
        ->isAlways()->toBeTrue()
        ->toArray()->toEqual([
            'name' => 'name',
            'label' => 'Name',
            'hidden' => false,
            'icon' => null,
            'toggle' => false,
            'active' => true,
            'class' => null,
            'sort' => null,
            'meta' => [],
        ]);
});

it('can be searchable', function () {
    expect($this->test)
        ->isSearchable()->toBeFalse()
        ->searchable()->toBeInstanceOf(Column::class)
        ->isSearchable()->toBeTrue();
});

it('can have classes', function () {
    expect($this->test)
        ->hasClass()->toBeFalse()
        ->getClass()->toBeNull()
        ->class('bg-red-500 text-white', 'font-bold')->toBeInstanceOf(Column::class)
        ->hasClass()->toBeTrue()
        ->getClass()->toBe('bg-red-500 text-white font-bold');
});
