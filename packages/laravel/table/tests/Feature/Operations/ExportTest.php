<?php

declare(strict_types=1);

use Honed\Table\Contracts\ExportsTable;
use Honed\Table\Exporters\EloquentExporter;
use Honed\Table\Operations\Export;
use Honed\Table\Exports\TableExport;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->export = Export::make('export');
});

it('sets callback', function () {
    expect($this->export)
        ->getUsingCallback()->toBeNull()
        ->using(fn () => 'test')->toBe($this->export)
        ->getUsingCallback()->toBeInstanceof(Closure::class);
});

it('sets exporter', function () {
    expect($this->export)
        ->getExporter()->toBe(EloquentExporter::class)
        ->exporter(Product::class)->toBe($this->export)
        ->getExporter()->toBe(Product::class);
});

it('has array representation', function () {
    expect($this->export->toArray())
        ->toBeArray()
        ->{'action'}->toBeTrue();
});