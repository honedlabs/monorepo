<?php

namespace Honed\Refine\Searches\Concerns;

trait HasBoolean
{
    /**
     * The query boolean to use for the instance.
     *
     * @var 'and'|'or'
     */
    protected $boolean = 'and';

    /**
     * Set the query boolean to use for the instance.
     *
     * @param  'and'|'or'  $boolean
     * @return $this
     */
    public function boolean($boolean)
    {
        $this->boolean = $boolean;

        return $this;
    }

    /**
     * Get the query boolean for the instance.
     *
     * @return 'and'|'or'
     */
    public function getBoolean()
    {
        return $this->boolean;
    }
}
