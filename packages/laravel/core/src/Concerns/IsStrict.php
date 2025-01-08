<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsStrict
{
    /**
     * @var bool
     */
    protected $strict = false;

    /**
     * Set the instance as strict.
     *
     * @param bool $strict The strict state to set.
     * @return $this
     */
    public function strict($strict = true)
    {
        $this->strict = $strict;

        return $this;
    }

    /**
     * Set the instance as relaxed.
     *
     * @param bool $relaxed The relaxed state to set.
     * @return $this
     */
    public function relaxed($relaxed = true)
    {
        return $this->strict(! $relaxed);
    }

    /**
     * Determine if the instance is strict.
     * 
     * @return bool True if the instance is strict, false otherwise.
     */
    public function isStrict()
    {
        return $this->strict;
    }
}
