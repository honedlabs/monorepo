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
     * @return $this
     */
    public function format(string|\Closure|null $format): static
    {
        if (! \is_null($format)) {
            $this->format = $format;
        }

        return $this;
    }

    /**
     * Get the format for the instance.
     */
    public function getFormat(): string
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
     */
    public function resolveFormat(array $parameters = [], array $typed = []): ?string
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->format, $parameters, $typed);

        $this->format = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a format set.
     */
    public function hasFormat(): bool
    {
        return ! \is_null($this->format);
    }
}
