<?php

namespace Honed\Refine\Concerns;

use Honed\Core\Concerns\HasResource;
use Honed\Core\Concerns\HasScope;
use Honed\Refine\Sorts\Concerns\HasSorts;
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

    // protected function scoutRefine()
    // {
    //     Product::search($this->getSearch(), $this->scoutCallback());
    // }

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
        if ($this->isScout()) {
        }
    }

    /**
     * Get the scout driver.
     * 
     * @return string|null
     */
    protected function getScoutDriver()
    {
        return config('scout.driver');
    }


    /**
     * Apply the filters to the resource.
     * 
     * @return void
     */
    protected function filter()
    {
        $resource = $this->getResource();
        $delimiter = $this->getDelimiter();


        foreach ($this->getFilters() as $filter) {
            $value = $filter->getRequestValue($this->request);

            $filter->refine($resource, $value);
        }

    }

    /**
     * Apply the sorts to the resource.
     * 
     * @return void
     */
    protected function sort()
    {

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
}