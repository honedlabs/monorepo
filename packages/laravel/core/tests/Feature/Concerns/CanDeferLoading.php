<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

trait CanDeferLoading
{
    /**
     * Defer the loading of the instance.
     * 
     * @param  bool  $value
     */
    public function deferLoading($value = true)
    {
        
    }

    /**
     * Lazily load the instance.
     * 
     * @param  bool  $value
     */
    public function lazyLoading($value = true)
    {

    }

    /** */
}