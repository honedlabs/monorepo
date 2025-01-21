<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

trait HasCallback
{
    /**
     * @var string|callable|object
     */
    protected $callback;

    /**
     * @param string|callable|object $callback
     */
    public function callback($callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    public function getCallback(): object
    {
        if (\is_null($this->callback)) {
            throw new \InvalidArgumentException('No callback has been set.');
        }

        if (\is_string($this->callback) && class_exists($this->callback)) {
            return resolve($this->callback);
        }

        return $this->callback;
    }
}