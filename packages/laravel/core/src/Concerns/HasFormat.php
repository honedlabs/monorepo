<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasFormat
{
    /**
     * @var string|\Closure|null
     */
    protected $format;

    /**
     * Set the format for the instance.
     *
     * @param  string|\Closure|null  $format
     * @return $this
     */
    public function format($format)
    {
        if (! \is_null($format)) {
            $this->format = $format;
        }

        return $this;
    }

    /**
     * Get the format for the instance.
     *
     * @return string|null
     */
    public function getFormat()
    {
        return $this->format instanceof \Closure
            ? $this->resolveFormat()
            : $this->format;
    }

    /**
     * Evaluate the format for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return string|null
     */
    public function resolveFormat($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->format, $parameters, $typed);

        $this->format = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a format set.
     *
     * @return bool
     */
    public function hasFormat()
    {
        return ! \is_null($this->format);
    }
}
