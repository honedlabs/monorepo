<?php

namespace Honed\Refine\Concerns;

use Honed\Core\Interpret;
use Honed\Core\Concerns\HasScope;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Concerns\HasResource;
use Illuminate\Support\Facades\Config;
use Honed\Refine\Sorts\Concerns\HasSorts;
use Honed\Refine\Filters\Concerns\HasFilters;
use Honed\Refine\Searches\Concerns\HasSearches;

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
     * Indicate whether to use Laravel Scout as the driver.
     * 
     * @var bool
     */
    protected $scout = false;

    /**
     * The callback to be processed before the refiners.
     *
     * @var \Closure
     */
    protected $before;

    /**
     * The callback to be processed after refinement.
     *
     * @var \Closure
     */
    protected $after;

    /**
     * Set whether to use Laravel Scout as the driver.
     *
     * @param bool $scout
     * @return $this
     */
    public function scout($scout)
    {
        $this->scout = $scout;

        return $this;
    }

    /**
     * Determine if Laravel Scout is being used as the driver.
     *
     * @return bool
     */
    public function isScout()
    {
        return $this->scout;
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
     * @return \Closure
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
     * @return \Closure
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

        if ($this->isScout()) {
            $this->scoutRefine();
        } else {
            $this->eloquentRefine();
        }

        $this->refined = true;

        return $this;
    }


    /**
     * Get the scout driver.
     * 
     * @return string|null
     */
    protected function getScoutDriver()
    {
        /** @var string|null */
        return Config::get('scout.driver');
    }

    /**
     * Refine the resource using the scout driver.
     * 
     * @return void
     */
    protected function scoutRefine()
    {
        // Product::search($this->getSearch(), $this->scoutCallback());
    }

    // protected function scoutCallback()
    // {
    //     return match ($this->getScoutDriver()) {
    //         'meilisearch' => $this->meilisearchCallback(),
    //         default => null,
    //     };
    // }

    // protected function meilisearchCallback()
    // {
    //     // Map through the filters and get the active ones.

    //     return function ($meilisearch, $query, $options) {
    //         $options['sort'] = [$filters['sort'].':'.$filters['sort_direction']];
    //         $options['filter'] = 'created_at > '.$filter['created_after'].' AND company_id = "'.$filter['company_id'].'"';
    
    //         return $meilisearch->search($query, $options);
    //     }

    // }

    /**
     * Refine the resource using the eloquent driver.
     * 
     * @return void
     */
    public function eloquentRefine()
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
        $this->term($this->getSearch($this->request));
        $columns = $this->getMatch($this->request);

        $or = false;

        foreach ($this->getSearches() as $search) {
            $or |= $search->handle($this->resource, $this->term, $or, $columns);
        }
    }

    /**
     * Apply the filters to the resource.
     * 
     * @return void
     */
    protected function filter()
    {
        $delimiter = $this->getDelimiter();
        
        foreach ($this->getFilters() as $filter) {
            $key = $this->formatScope($filter->getParameter());

            $value = $filter->getRequestValue(
                $this->request, $key, $delimiter
            );

            $filter->handle($this->resource, $value);
        }
    }

    /**
     * Apply the sorts to the resource.
     * 
     * @return void
     */
    protected function sort()
    {
        [$parameter, $direction] = $this->getSort($this->request);

        foreach ($this->getSorts() as $sort) {
            $sort->handle($this->resource, $parameter, $direction);
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
     * Determine if the refinements have been processed.
     * 
     * @return bool
     */
    public function isRefined()
    {
        return $this->refined;
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
        // if ($this->isNotMatchable()) {
        //     return null;
        // }

        $delimiter = $this->getDelimiter();
        $key = $this->getMatchKey();

        return Interpret::array($request, $key, $delimiter, 'string');
    }
}