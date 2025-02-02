<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasDescription
{
    /**
     * @var string|\Closure|null
     */
    protected $description;

    /**
     * Set the description for the instance.
     *
     * @return $this
     */
    public function description(string|\Closure|null $description): static
    {
        if (! \is_null($description)) {
            $this->description = $description;
        }

        return $this;
    }

    /**
     * Get the description for the instance.
     */
    public function getDescription(): ?string
    {
        return $this->description instanceof \Closure
            ? $this->resolveDescription()
            : $this->description;
    }

    /**
     * Evaluate the description for the instance.
     *
     * @param  array<string,mixed> $parameters
     * @param  array<string,mixed>  $typed
     */
    public function resolveDescription(array $parameters = [], array $typed = []): ?string
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->description, $parameters, $typed);

        $this->description = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a description set.
     */
    public function hasDescription(): bool
    {
        return ! \is_null($this->description);
    }
}
