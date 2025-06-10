<?php

namespace Honed\Refine\Concerns;

use Honed\Core\Interpret;
use Honed\Core\Concerns\HasScope;
use Honed\Core\Concerns\HasRequest;
use Honed\Refine\Concerns\HasResource;
use Illuminate\Support\Facades\Config;
use Honed\Refine\Sorts\Concerns\HasSorts;
use Honed\Refine\Filters\Concerns\HasFilters;
use Honed\Refine\Searches\Concerns\HasSearches;
use Workbench\App\Models\Product;

trait CanRefine
{
    use HasDelimiter;
    use HasScope;
    use HasSorts;
    use HasRequest;
    use HasFilters;
    use HasSearches;
    use HasResource;

    /**
     * Indicate whether the refinements have been processed.
     * 
     * @var bool
     */
    protected $refined = false;

    /**
     * The callback to be processed before the refiners.
     *
     * @var \Closure|null
     */
    protected $before;

    /**
     * The callback to be processed after refinement.
     *
     * @var \Closure|null
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
     * @param \Closure $callback
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
     * @return \Closure|null
     */
    public function getBeforeCallback()
    {
        return $this->before;
    }

    /**
     * Register the callback to be executed after refinement.
     *
     * @param \Closure $callback
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
     * @return \Closure|null
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
        $this->term($this->getSearch($this->request));
        $columns = $this->getMatch($this->request);

        if ($this->isScout()) {
            $model = $this->getModel();

            $builder->whereIn(
                $model->getKeyName(),
                // @phpstan-ignore-next-line method.notFound
                $model->search($this->term)->keys() 
            );
            
            return;
        }

        $or = false;

        foreach ($this->getSearches() as $search) {
            $or |= $search->handle(
                $builder, $this->term, $or, $columns
            );
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

        foreach ($this->getFilters() as $filter) {
            $key = $this->formatScope($filter->getParameter());

            $value = $filter->getRequestValue(
                $this->request, $key, $this->delimiter
            );

            $filter->handle($builder, $value);
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
        [$parameter, $direction] = $this->getSort($this->request);

        $sorted = false;

        foreach ($this->getSorts() as $sort) {
            $sorted |= $sort->handle(
                $builder, $parameter, $direction
            );
        }

        if (! $sorted && $sort = $this->getDefaultSort()) {
            $sort->handle(
                $builder, $parameter, $direction
            );

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

    /**
     * Get the search term from the request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function getSearch($request)
    {
        $key = $this->getSearchKey();

        $term = Interpret::string($request, $key);

        if (! $term) {
            return null;
        }

        return str_replace('+', ' ', trim($term));
    }

    /**
     * Get the sort parameter from the request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return array{string|null, 'asc'|'desc'|null}
     */
    protected function getSort($request)
    {
        $key = $this->getSortKey();

        $sort = Interpret::string($request, $key);

        return match (true) {
            ! $sort => [null, null],
            str_starts_with($sort, '-') => [mb_substr($sort, 1), 'desc'],
            default => [$sort, 'asc'],
        };
    }

    /**
     * Get the search columns from the request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return array<int,string>|null
     */
    protected function getMatch($request)
    {
        if ($this->isNotMatchable()) {
            return null;
        }

        $delimiter = $this->getDelimiter();
        $key = $this->getMatchKey();

        return Interpret::array($request, $key, $delimiter, 'string');
    }
}