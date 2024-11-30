<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasSuffix
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $suffix = null;

    /**
     * Set the suffix, chainable.
     *
     * @param string|(\Closure(mixed...):string) $suffix
     * @return $this
     */
    public function suffix(string|\Closure $suffix): static
    {
        $this->setSuffix($suffix);

        return $this;
    }

    /**
     * Set the suffix quietly.
     *
     * @param string|(\Closure(mixed...):string)|null $suffix
     */
    public function setSuffix(string|\Closure|null $suffix): void
    {
        if (\is_null($suffix)) {
            return;
        }

        $this->suffix = $suffix;
    }

    /**
     * Get the suffix.
     * 
     * @param mixed $parameter
     * @return string|null
     */
    public function getSuffix($parameter = null): ?string
    {
        return value($this->suffix, $parameter);
    }

    /**
     * Determine if the class does not have a suffix.
     * 
     * @return bool
     */
    public function missingSuffix(): bool
    {
        return \is_null($this->suffix);
    }

    /**
     * Determine if the class has a suffix.
     *
     * @return bool
     */
    public function hasSuffix(): bool
    {
        return ! $this->missingSuffix();
    }
}
