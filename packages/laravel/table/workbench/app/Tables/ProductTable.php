<?php

declare(strict_types=1);

namespace Workbench\App\Tables;

use Honed\Action\Operations\BulkOperation;
use Honed\Action\Operations\InlineOperation;
use Honed\Action\Operations\PageOperation;
use Honed\Refine\Filters\Filter;
use Honed\Refine\Searches\Search;
use Honed\Refine\Sorts\Sort;
use Honed\Table\Columns\BooleanColumn;
use Honed\Table\Columns\Column;
use Honed\Table\Columns\DateColumn;
use Honed\Table\Columns\KeyColumn;
use Honed\Table\Columns\NumericColumn;
use Honed\Table\Columns\TextColumn;
use Honed\Table\Contracts\IsOrderable;
use Honed\Table\Contracts\IsSelectable;
use Honed\Table\Contracts\IsToggleable;
use Honed\Table\Table;
use Workbench\App\Enums\Status;
use Workbench\App\Models\Product;

/**
 * @template TModel of \Workbench\App\Models\Product
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends Table<TModel, TBuilder>
 */
class ProductTable extends Table implements IsOrderable, IsSelectable, IsToggleable
{
    /**
     * Define the table.
     *
     * @param  $this  $table
     * @return $this
     */
    protected function definition(Table $table): Table
    {
        return $table
            ->for(Product::query())
            ->columns([
                KeyColumn::make('id'),

                TextColumn::make('name')
                    ->defaultToggled()
                    ->always()
                    ->searchable(),

                TextColumn::make('description')
                    ->defaultToggled()
                    ->filterable()
                    ->placeholder('-'),

                BooleanColumn::make('best_seller', 'Favourite')
                    ->trueText('Favourite')
                    ->falseText('Not favourite'),

                TextColumn::make('seller.name', 'Sold by')
                    ->defaultToggled(),

                Column::make('status'),

                NumericColumn::make('price')
                    ->alias('cost')
                    ->sortable(),

                DateColumn::make('created_at')
                    ->sortable(),

                Column::make('public_id')
                    ->hidden()
                    ->always(),

                DateColumn::make('updated_at')
                    ->filterable()
                    ->allow(false),
            ])
            ->persistColumnsInCookie()
            // ->perPage([10, 25, 50])
            // ->defaultPerPage(15)
            ->filters([
                Filter::make('name')->operator('like'),

                Filter::make('price', 'Maximum price')
                    ->strict()
                    ->operator('<=')
                    ->options([10, 20, 50, 100]),

                Filter::make('status')
                    ->enum(Status::class)
                    ->multiple(),

                Filter::make('status', 'Single')
                    ->alias('only')
                    ->enum(Status::class),

                Filter::make('best_seller', 'Favourite')
                    ->boolean()
                    ->alias('favourite'),

                Filter::make('created_at', 'Oldest')
                    ->alias('oldest')
                    ->date()
                    ->operator('>='),

                Filter::make('created_at', 'Newest')
                    ->alias('newest')
                    ->operator('<=')
                    ->date(),
            ])
            ->sorts([
                Sort::make('name', 'A-Z')
                    ->desc()
                    ->default(),

                Sort::make('name', 'Z-A')
                    ->asc(),

                Sort::make('price'),

                Sort::make('best_seller', 'Favourite')
                    ->alias('favourite'),

                Sort::make('updated_at')
                    ->allow(false),
            ])
            ->searches([
                Search::make('description'),
            ])
            ->operations([
                InlineOperation::make('edit')
                    ->action(fn ($product) => $product->update(['name' => 'Inline'])),

                InlineOperation::make('delete')
                    ->allow(fn ($product) => $product->id % 2 === 0)
                    ->action(fn ($product) => $product->delete())
                    ->confirmable(fn ($confirm) => $confirm
                        ->title(fn ($product) => 'You are about to delete '.$product->name)
                        ->description('Are you sure?')),

                InlineOperation::make('show')
                    ->route(fn ($product) => route('products.show', $product)),

                BulkOperation::make('edit')
                    ->action(fn ($product) => $product->update(['name' => 'Bulk'])),

                BulkOperation::make('delete')
                    ->action(fn ($product) => $product->delete())
                    ->allow(false),

                PageOperation::make('create')
                    ->route('products.create'),

                PageOperation::make('factory')
                    ->action(function () {
                        $product = product('test');

                        return to_route('products.show', $product);
                    }),

            ]);
    }
}
