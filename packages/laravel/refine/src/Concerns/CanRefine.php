<?php

namespace Honed\Refine\Concerns;

use Honed\Core\Concerns\HasScope;

trait CanRefine
{
    use HasScope;
    use HasSorts;
    use HasFilters;
    use HasSearches;
    // use HasRequest;

    protected $refined = false;

    public function refine()
    {
        if ($this->isRefined()) {
            return $this;
        }

        foreach ($this->pipelines() as $pipeline) {
            $pipeline();
        }

        $this->refined = true;

        return $this;
    }

    abstract protected function pipelines();


    protected function actBefore()
    {
        
    }

    protected function search()
    {

    }

    protected function sort()
    {

    }

    protected function filter()
    {

    }


    protected function actAfter()
    {

    }

    public function isRefined()
    {
        return $this->refined;
    }
}