<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasPrefix
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $prefix = null;

    /**
     * Set the prefix, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $prefix
     * @return $this
     */
    public function prefix(string|\Closure $prefix): static
    {
        $this->setPrefix($prefix);

        return $this;
    }

    /**
     * Set the prefix quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $prefix
     */
    public function setPrefix(string|\Closure|null $prefix): void
    {
        if (\is_null($prefix)) {
            return;
        }

        $this->prefix = $prefix;
    }

    /**
     * Get the prefix.
     *
     * @param  mixed  $parameter
     */
    public function getPrefix($parameter = null): ?string
    {
        return value($this->prefix, $parameter);
    }

    /**
     * Determine if the class does not have a prefix.
     */
    public function missingPrefix(): bool
    {
        return \is_null($this->prefix);
    }

    /**
     * Determine if the class has a prefix.
     */
    public function hasPrefix(): bool
    {
        return ! $this->missingPrefix();
    }
}
