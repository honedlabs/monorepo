<?php

namespace App\Refiners;

use Honed\Refine\Refine;
use Workbench\App\Models\User;

class RefineUser extends Refine
{
    /**
     * Define the refine for the model.
     */
    protected function definition(Refine $refine): Refine
    {
        return $refine->for(User::class)
            ->scope('table')
            ->searchPlaceholder()
            ->sortKey('sort')
            ->searchKey('q')
            ->matchKey('row')
            ->match()
            ->sortable(false)
            ->searchable(false)
            ->notFilterable()
            ->filters([

            ])
            ->sorts([
                
            ])
            ->searches([
                
            ])
            ->cookie(static::class)
            ->persist()
            ->persistSorts()
            ->persistSearches()
            ->persistFilters()
            ->defaultSort(Sort::make())
            ->scout();
    }

    public function setUp()
    {

    }
}