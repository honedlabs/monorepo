<?php

namespace Workbench\App\ActionGroups;

use Honed\Action\ActionGroup;
use Honed\Action\InlineAction;
use Honed\Action\BulkAction;
use Honed\Action\PageAction;

/**
 * @template TModel of \Workbench\App\Models\User = \Workbench\App\Models\User
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Action\ActionGroup<TModel, TBuilder>
 */
class UserActions extends ActionGroup
{
    /**
     * Provide the action group with any necessary setup
     *
     * @return void
     */
    public function setUp()
    {
        //
    }

    /**
     * Define the available actions.
     *
     * @return array<int,\Honed\Action\Action|\Honed\Action\ActionGroup<TModel, TBuilder>>
     */
    public function actions()
    {
        /** @var array<int,\Honed\Action\Action|\Honed\Action\ActionGroup<TModel, TBuilder>> */
        return [
            InlineAction::make('update.name')
                ->action(fn ($product) => $product->update(['name' => 'test'])),

            InlineAction::make('show')
                ->route(fn ($product) => route('products.show', $product->public_id)),

            InlineAction::make('price.100')
                ->action(function ($product) {
                    $product->update(['price' => 100]);

                    return inertia('Show');
                }),

            InlineAction::make('update.description')
                ->action(fn ($product) => $product->update(['description' => 'test']))
                ->allow(false),

            BulkAction::make('update.name')
                ->action(fn ($product) => $product->update(['name' => 'test']))
                ->allow(false),

            BulkAction::make('update.description')
                ->action(fn ($product) => $product->update(['description' => 'test'])),

            BulkAction::make('price.50')
                ->action(function (Collection $products) {
                    $products->each->update(['price' => 50]);

                    return inertia('Show');
                }),

            PageAction::make('create.product.name')
                ->action(fn () => Product::create([
                    'name' => 'name',
                    'description' => 'name',
                ])),

            PageAction::make('create.product.description')
                ->action(fn () => Product::create([
                    'name' => 'description',
                    'description' => 'description',
                ]))
                ->allow(false),

            PageAction::make('create')
                ->route('products.create'),

            PageAction::make('price.10')
                ->action(function (Builder $builder) {
                    $builder->update(['price' => 10]);

                    return inertia('Show');
                }),
        ];
    }
}