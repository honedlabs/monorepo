<?php

declare(strict_types=1);

use Honed\Table\Exporters\EloquentExporter;
use Honed\Table\Operations\Export;
use Honed\Table\Table;
use Maatwebsite\Excel\Excel as ExcelClass;

use Maatwebsite\Excel\Facades\Excel;
use Workbench\App\Models\Product;
use Workbench\App\Tables\ProductTable;

beforeEach(function () {
    $this->export = Export::make('export')
        ->fileName('products.xlsx')
        ->fileType(ExcelClass::XLSX);

    $this->table = Table::make()
        ->for(Product::class)
        ->operation($this->export);

    Excel::fake();
});

it('sets callback', function () {
    expect($this->export)
        ->getUsingCallback()->toBeNull()
        ->using(fn () => 'test')->toBe($this->export)
        ->getUsingCallback()->toBeInstanceof(Closure::class);
});

it('sets exporter', function () {
    expect($this->export)
        ->getExporter($this->table)->toBe(EloquentExporter::class)
        ->exporter(Product::class)->toBe($this->export)
        ->getExporter($this->table)->toBe(Product::class);
});

it('has array representation', function () {
    expect($this->export->toArray())
        ->toBeArray()
        ->{'action'}->toBeTrue();
});

it('handles action', function () {
    $this->export->handle($this->table);

    Excel::assertDownloaded('products.xlsx');
});