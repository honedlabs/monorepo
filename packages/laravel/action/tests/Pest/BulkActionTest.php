<?php

declare(strict_types=1);

use Honed\Action\BulkAction;
use Honed\Action\Tests\Stubs\Product;

beforeEach(function () {
    $this->action = BulkAction::make('test');
});

it('makes', function () {
    expect($this->action)
        ->toBeInstanceOf(BulkAction::class);
});

it('has array representation', function () {
    expect($this->action->toArray())
        ->toBeArray()
        ->toHaveKeys(['name', 'label', 'type', 'icon', 'extra', 'action']);
});

it('tests', function () {
    dd($this->action->execute(Product::query()));
});