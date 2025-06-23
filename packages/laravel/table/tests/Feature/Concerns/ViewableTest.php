<?php

declare(strict_types=1);

use Honed\Table\PendingViewInteraction;
use Honed\Table\Table;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->table = Table::make();
});

it('is viewable', function () {
    expect($this->table)
        ->isViewable()->toBeFalse()
        ->getViews()->toBeNull()
        ->viewable()->toBe($this->table)
        ->isViewable()->toBeTrue()
        ->getViews()->toBeInstanceOf(PendingViewInteraction::class);
});

it('is viewable with scopes', function () {
    expect($this->table)
        ->getViews()->toBeNull()
        ->viewable(Product::factory()->create())->toBe($this->table)
        ->getViews()->toBeInstanceOf(PendingViewInteraction::class);
});
