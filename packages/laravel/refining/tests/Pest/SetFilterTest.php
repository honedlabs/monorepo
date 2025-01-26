<?php

declare(strict_types=1);

use Honed\Refining\Filters\SetFilter;
use Honed\Refining\Tests\Stubs\Status;
use Honed\Refining\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;
use Honed\Refining\Filters\Concerns\Option;

beforeEach(function () {
    $this->builder = Product::query();
    $this->param = 'status';
    $this->filter = SetFilter::make($this->param);
});

it('can be multiple', function () {
    expect($this->filter)
        ->isMultiple()->toBeFalse()
        ->multiple()->toBe($this->filter)
        ->isMultiple()->toBeTrue();
});

it('has options', function () {
    expect($this->filter)
        ->hasOptions()->toBeFalse()
        ->enum(Status::class)->toBe($this->filter)
        ->hasOptions()->toBeTrue()
        ->getOptions()->scoped(fn ($options) => $options
            ->toBeArray()
            ->toHaveCount(3)
            ->{0}->scoped(fn ($option) => $option
                ->getValue()->toBe(Status::Available->value)
                ->getLabel()->toBe(Status::Available->name)
                ->isActive()->toBeFalse()
            )->{1}->scoped(fn ($option) => $option
                ->getValue()->toBe(Status::Unavailable->value)
                ->getLabel()->toBe(Status::Unavailable->name)
                ->isActive()->toBeFalse()
            )->{2}->scoped(fn ($option) => $option
                ->getValue()->toBe(Status::ComingSoon->value)
                ->getLabel()->toBe(Status::ComingSoon->name)
                ->isActive()->toBeFalse()
            )
        )->options([1, 2, 3])->toBe($this->filter)
        ->getOptions()->scoped(fn ($options) => $options
            ->toBeArray()
            ->toHaveCount(3)
            ->{0}->scoped(fn ($option) => $option
                ->getValue()->toBe(1)
                ->getLabel()->toBe('1')
                ->isActive()->toBeFalse()
            )->{1}->scoped(fn ($option) => $option
                ->getValue()->toBe(2)
                ->getLabel()->toBe('2')
                ->isActive()->toBeFalse()
            )->{2}->scoped(fn ($option) => $option
                ->getValue()->toBe(3)
                ->getLabel()->toBe('3')
                ->isActive()->toBeFalse()
            )
        )->options(collect(Status::cases())
            ->flatMap(fn ($case) => [$case->value => $case->name])
        )->toBe($this->filter)
        ->getOptions()->scoped(fn ($options) => $options
            ->toBeArray()
            ->toHaveCount(3)
            ->{0}->scoped(fn ($option) => $option
                ->getValue()->toBe(Status::Available->value)
                ->getLabel()->toBe(Status::Available->name)
                ->isActive()->toBeFalse()
            )->{1}->scoped(fn ($option) => $option
                ->getValue()->toBe(Status::Unavailable->value)
                ->getLabel()->toBe(Status::Unavailable->name)
                ->isActive()->toBeFalse()
            )->{2}->scoped(fn ($option) => $option
                ->getValue()->toBe(Status::ComingSoon->value)
                ->getLabel()->toBe(Status::ComingSoon->name)
                ->isActive()->toBeFalse()
            )
        );
});


it('filters with options', function () {
    $request = Request::create('/', 'GET', [$this->param => Status::Available->value]);

    expect($this->filter->options(Status::class)->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
            ->{'column'}->toBe($this->builder->qualifyColumn('status'))
            ->{'value'}->toBe(Status::Available->value)
            ->{'operator'}->toBe('=')
            ->{'boolean'}->toBe('and')
        );
    
    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe(Status::Available->value);
});