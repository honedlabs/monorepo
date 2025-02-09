<?php

declare(strict_types=1);

namespace Honed\Table\Tests\Fixtures;

use Honed\Action\Confirm;
use Honed\Action\BulkAction;
use Honed\Action\PageAction;
use Honed\Refine\Sorts\Sort;
use Honed\Action\InlineAction;
use Honed\Table\Columns\Column;
use Honed\Refine\Filters\Filter;
use Honed\Refine\Filters\SetFilter;
use Honed\Table\Columns\DateColumn;
use Honed\Table\Columns\TextColumn;
use Honed\Table\Tests\Stubs\Status;
use Honed\Refine\Filters\DateFilter;
use Honed\Table\Table as HonedTable;
use Honed\Table\Tests\Stubs\Product;
use Honed\Refine\Filters\CustomFilter;
use Honed\Table\Columns\BooleanColumn;
use Honed\Table\Columns\NumericColumn;

class Table extends HonedTable
{
    public $resource = Product::class;

    public $search = ['description'];

    public $toggle = true;

    public $perPage = [10, 25, 50];

    public $defaultPerPage = 10;

    public $cookie = 'example-table';

    public function columns()
    {
        return [
            Column::make('id')->key(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('description')->placeholder('-'), //->truncate(100)
            BooleanColumn::make('best_seller', 'Favourite'), //->labels('Favourite', 'Not Favourite'),
            Column::make('status')->meta(['badge' => true]),
            NumericColumn::make('price')->currency(),
            DateColumn::make('created_at')->sortable(),
        ];
    }

    public function filters()
    {
        return [
            Filter::make('price', 'Max')->alias('max')->lte(),
            Filter::make('price', 'Min')->alias('min')->gt(),
            SetFilter::make('status')->options(Status::class)->strict(),
            DateFilter::make('created_at', 'Year')->alias('year')->year(),
        ];
    }

    public function sorts()
    {
        return [
            Sort::make('name', 'A-Z')->asc(),
            Sort::make('name', 'Z-A')->desc(),
        ];
    }

    public function actions()
    {
        return [
            InlineAction::make('edit')
                ->action(fn (Product $product) => $product->update(['name' => 'Inline']))
                ->bulk(),

            InlineAction::make('delete')
                ->allow(fn (Product $product) => $product->id % 2 === 0)
                ->action(fn (Product $product) => $product->delete())
                ->confirm(fn (Confirm $confirm) => $confirm->title(fn (Product $product) => 'You are about to delete '.$product->name)->description('Are you sure?')),

            InlineAction::make('show')
                ->route('products.show'),

            BulkAction::make('update')
                ->action(fn (Product $product) => $product->update(['name' => 'Bulk'])),

            PageAction::make('create')->route('products.create'),

        ];
    }
}
