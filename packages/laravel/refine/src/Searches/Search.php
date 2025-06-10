<?php

declare(strict_types=1);

namespace Honed\Refine\Searches;

use function is_null;
use function array_merge;

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
     * Define the type of the search.
     *
     * @return string
     */
    public function type()
    {
        return 'search';
    }

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
     * Define the search instance.
     *
     * @param  \Honed\Refine\Searches\Search<TModel, TBuilder>  $search
     * @return \Honed\Refine\Searches\Search<TModel, TBuilder>|void
     */
    protected function definition(Search $search)
    {
        return $search;
    }

    /**
     * Handle the refinement.
     * 
     * @param  TBuilder  $query
     * @param  string  $term
     * @param  bool  $or
     * @param  array<int, string>  $columns
     * @return bool
     */
    public function handle($query, $term, $or = false, $columns = [])
    {
        $this->active(! $term || ! in_array($term, $columns, true));

        if ($this->isInactive()) {
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
}
