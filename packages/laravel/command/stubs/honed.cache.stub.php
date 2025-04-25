<?php

declare(strict_types=1);

namespace {{ namespace }};

use Honed\Command\CacheManager;

class {{ class }} extends CacheManager
{
    /**
     * Get the value of the cache.
     * 
     * @return mixed
     */
    public function value()
    {

    }

    /**
     * Return the components to generate the cache key.
     * 
     * @return string|list<string>
     */
    public function key()
    {

    }
}