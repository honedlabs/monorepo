<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Closure;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Concerns\HasScope;
use Honed\Refine\Filters\Concerns\HasFilters;
use Honed\Refine\Searches\Concerns\HasSearches;
use Honed\Refine\Sorts\Concerns\HasSorts;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;

trait CanBeRefined
{
    use CanPersistRefinements;
    use HasDelimiter;
    use HasFilters;
    use HasRequest;
    use HasResource;
    use HasScope;
    use HasSearches;
    use HasSorts;

    /**
     * Indicate whether the refinements have been processed.
     *
     * @var bool
     */
    protected $refined = false;

    /**
     * The callback to be processed before the refiners.
     *
     * @var Closure|null
     */
    protected $before;

    /**
     * The callback to be processed after refinement.
     *
     * @var Closure|null
     */
    protected $after;

    /**
     * Determine if the refinements have been processed.
     *
     * @return bool
     */
    public function isRefined()
    {
        return $this->refined;
    }

    /**
     * Register the callback to be executed before the refiners.
     *
     * @param  Closure  $callback
     * @return $this
     */
    public function before($callback)
    {
        $this->before = $callback;

        return $this;
    }

    /**
     * Get the callback to be executed before the refiners.
     *
     * @return Closure|null
     */
    public function getBeforeCallback()
    {
        return $this->before;
    }

    /**
     * Register the callback to be executed after refinement.
     *
     * @param  Closure  $callback
     * @return $this
     */
    public function after($callback)
    {
        $this->after = $callback;

        return $this;
    }

    /**
     * Get the callback to be executed after refinement.
     *
     * @return Closure|null
     */
    public function getAfterCallback()
    {
        return $this->after;
    }

    /**
     * Refine the provided resource.
     *
     * @return $this
     */
    public function refine()
    {
        if ($this->isRefined()) {
            return $this;
        }

        $this->pipeline();

        $this->refined = true;

        return $this;
    }

    /**
     * Get the refined data.
     *
     * @return array<string, mixed>
     */
    public function refineToArray()
    {
        return [
            'sort' => $this->getSortKey(),
            'search' => $this->getSearchKey(),
            'match' => $this->getMatchKey(),
            'term' => $this->getTerm(),
            'delimiter' => $this->getDelimiter(),
            'placeholder' => $this->getSearchPlaceholder(),
            'sorts' => $this->sortsToArray(),
            'filters' => $this->filtersToArray(),
            'searches' => $this->searchesToArray(),
        ];
    }

    /**
     * Execute the pipeline of refiners.
     *
     * @return void
     */
    protected function pipeline()
    {
        $this->actBefore();
        $this->search();
        $this->filter();
        $this->sort();
        $this->actAfter();
        $this->persist();
    }

    /**
     * Modify the resource before the refiners are processed.
     *
     * @return void
     */
    protected function actBefore()
    {
        $this->evaluate($this->before);
    }

    /**
     * Apply the searches to the resource.
     *
     * @return void
     */
    protected function search()
    {
        $builder = $this->getBuilder();

        [$persistedTerm, $persistedColumns] = $this->getPersistedSearchValue();

        $this->term = $this->getSearchValue($this->request) ?? $persistedTerm;

        $columns = $this->getSearchColumns($this->request) ?? $persistedColumns;

        $this->persistSearchValue($this->term, $columns);

        if ($this->isScout()) {
            $model = $this->getModel();

            $builder->whereIn(
                $builder->qualifyColumn($model->getKeyName()),
                // @phpstan-ignore-next-line method.notFound
                $model->search($this->term)->keys()
            );

            return;
        }

        $or = false;

        foreach ($this->getSearches() as $search) {
            $or = $search->handle(
                $builder, $this->term, $columns, $or
            ) || $or;
        }
    }

    /**
     * Apply the filters to the resource.
     *
     * @return void
     */
    protected function filter()
    {
        $builder = $this->getBuilder();

        $applied = false;

        foreach ($this->getFilters() as $filter) {
            $value = $this->getFilterValue($this->request, $filter);

            $applied = $filter->handle($builder, $value) || $applied;

            $this->persistFilterValue($filter, $value);
        }

        if ($applied) {
            return;
        }

        foreach ($this->getFilters() as $filter) {
            $value = $this->getPersistedFilterValue($filter);

            $filter->handle($builder, $value);

            $this->persistFilterValue($filter, $value);
        }
    }

    /**
     * Apply the sorts to the resource.
     *
     * @return void
     */
    protected function sort()
    {
        $builder = $this->getBuilder();

        [$parameter, $direction] = $this->getSortValue($this->request);

        if (! $parameter) {
            [$parameter, $direction] = $this->getPersistedSortValue();
        }

        $this->persistSortValue($parameter, $direction);

        $applied = false;
    
        foreach ($this->getSorts() as $sort) {
            $applied = $sort->handle(
                $builder, $parameter, $direction
            ) || $applied;
        }
    
        if (! $applied && $sort = $this->getDefaultSort()) {
            $parameter = $sort->getParameter();
    
            $sort->handle($builder, $parameter, $direction);
    
            return;
        }
    }

    /**
     * Modify the resource after the refiners have been processed.
     *
     * @return void
     */
    protected function actAfter()
    {
        $this->evaluate($this->after);
    }
}
