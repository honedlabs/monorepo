<?php

declare(strict_types=1);

namespace Honed\Refine;

use Honed\Core\Contracts\DefinesQuery;
use Honed\Refine\Contracts\DefinesOptions;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Filter<TModel, TBuilder>
 */
final class TrashedFilter extends Filter implements DefinesOptions, DefinesQuery
{
    /**
     *  Create a new sort instance.
     *
     * @return static
     */
    public static function new()
    {
        return resolve(static::class);
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->name('trashed');
        $this->type('trashed');
        $this->label('Show deleted');
    }

    /**
     * Register the query expression to resolve the filter.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed $value
     * @return void
     */
    public function defineQuery(Builder $builder, $value)
    {
        match ($value) {
            'with' => $builder->withTrashed(),
            'only' => $builder->onlyTrashed(),
            default => $builder->withoutTrashed(),
        };
    }

    /**
     * Define the options to be supplied by the refinement.
     * 
     * @return class-string<\BackedEnum>|array<int|string,mixed>
     */
    public function defineOptions()
    {
        return [
            'with' => 'With deleted',
            'only' => 'Only deleted',
            'without' => 'Without deleted',
        ];
    }    
}