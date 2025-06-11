<?php

declare(strict_types=1);

namespace Honed\Refine\Searches;

use Closure;
use Honed\Refine\Refiner;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Refiner<TModel, TBuilder>
 */
class Search extends Refiner
{
    /**
     * @use Concerns\HasSearch<TModel, TBuilder>
     */
    use Concerns\HasSearch;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->definition($this);
    }

    /**
     * Handle the refinement.
     *
     * @param  TBuilder  $query
     * @param  string|null  $term
     * @param  array<int, string>|null  $columns
     * @param  bool  $or
     * @return bool
     */
    public function handle($query, $term, $columns, $or = false)
    {
        $this->checkIfActive($columns, $term);

        if ($this->isInactive() || ! $term) {
            return false;
        }

        if (! $this->hasQuery()) {
            $this->query(Closure::fromCallable([$this, 'apply']));
        }

        $this->modifyQuery($query, [
            ...$this->getBindings($term, $query),
            'boolean' => $or ? 'or' : 'and',
            'term' => $term,
            'search' => $term,
        ]);

        return true;
    }

    /**
     * Add the search query scope to the builder.
     *
     * @param  TBuilder  $builder
     * @param  string  $value
     * @param  string  $column
     * @param  string  $boolean
     * @return void
     */
    public function apply($builder, $value, $column, $boolean = 'and')
    {
        if ($this->isFullText()) {
            $this->searchRecall($builder, $value, $column, $boolean);

            return;
        }

        $this->searchPrecision($builder, $value, $column, $boolean);
    }

    /**
     * Define the search instance.
     *
     * @param  Search<TModel, TBuilder>  $search
     * @return Search<TModel, TBuilder>|void
     */
    protected function definition(self $search)
    {
        return $search;
    }

    /**
     * Check if the search is active.
     *
     * @param  array<int, string>|null  $column
     * @param  string  $term
     * @return void
     */
    protected function checkIfActive($columns, $term)
    {
        $this->active(! $columns || ! in_array($term, $columns, true));
    }
}
