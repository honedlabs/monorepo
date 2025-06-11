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
     * Handle the searching of the query.
     *
     * @param  TBuilder  $query
     * @param  string|null  $term
     * @param  array<int, string>|null  $columns
     * @param  bool  $or
     * @return bool
     */
    public function handle($query, $term, $columns, $or)
    {
        $this->checkIfActive($columns);

        if ($this->isInactive() || ! $term) {
            return false;
        }

        return $this->refine($query, [
            ...$this->getBindings($query),
            'boolean' => $or ? 'or' : 'and',
            'search' => $term,
            'term' => $term,
        ]);
    }

    /**
     * Add a search scope to the query.
     *
     * @param  TBuilder  $query
     * @param  string  $term
     * @param  string  $column
     * @param  string  $boolean
     * @return void
     */
    public function apply($query, $term, $column, $boolean)
    {
        if ($this->isFullText()) {
            $this->searchRecall($query, $term, $column, $boolean);

            return;
        }

        $this->searchPrecision($query, $term, $column, $boolean);
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
     * Determine if the search is active.
     *
     * @param  array<int, string>|null  $columns
     * @return void
     */
    protected function checkIfActive($columns)
    {
        $this->active(
            (! $columns) ?: in_array($this->getParameter(), $columns, true),
        );
    }
}
