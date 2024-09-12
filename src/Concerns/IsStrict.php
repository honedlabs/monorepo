<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;

trait IsStrict
{
    /**
     * @var bool|Closure
     */
    protected $strict = false;

    /**
     * Set whether the class is strict.
     *
     * @param  bool|Closure  $strict
     * @return $this
     */
    public function strict($strict = true)
    {
        $this->setStrict($strict);

        return $this;
    }

    /**
     * Set whether the class is strict quietly.
     */
    public function setStrict(bool|Closure|null $strict)
    {
        if (is_null($strict)) {
            return;
        }
        $this->strict = $strict;
    }

    /**
     * Check if the class is strict
     *
     * @return bool
     */
    public function isStrict()
    {
        return (bool) $this->evaluate($this->strict);
    }

    /**
     * Check if the class is not strict
     *
     * @return bool
     */
    public function isNotStrict()
    {
        return ! $this->isStrict();
    }
}
