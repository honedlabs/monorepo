<?php

declare(strict_types=1);

use Honed\Refine\Filters\PresenceFilter;
use Illuminate\Support\Facades\Request;
use Workbench\App\Enums\Status;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->builder = Product::query();

    $this->filter = PresenceFilter::make('status')
        ->query(fn ($query) => $query->where('status', Status::Available->value));
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('boolean')
        ->interpretsAs()->toBe('boolean')
        ->isPresence()->toBeTrue();
});

it('does not apply', function () {
    expect($this->filter)
        ->handle($this->builder, null)->toBeFalse();

    expect($this->builder->getQuery()->wheres)
        ->toBeEmpty();
});

it('applies', function () {
    expect($this->filter)
        ->handle($this->builder, true)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere('status', Status::Available->value);
});
