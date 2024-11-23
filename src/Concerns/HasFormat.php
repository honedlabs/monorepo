<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasFormat
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $format = null;

    /**
     * Set the format, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $format
     * @return $this
     */
    public function format(string|\Closure $format): static
    {
        $this->setFormat($format);

        return $this;
    }

    /**
     * Set the format quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $format
     */
    public function setFormat(string|\Closure|null $format): void
    {
        if (is_null($format)) {
            return;
        }
        $this->format = $format;
    }

    /**
     * Get the format using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return string|null
     */
    public function getFormat(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->format, $named, $typed);
    }

    /**
     * Resolve the format using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return string|null
     */
    public function resolveFormat(array $named = [], array $typed = []): ?string
    {
        $this->setFormat($this->getFormat($named, $typed));

        return $this->format;
    }

    /**
     * Determine if the class does not have a format.
     *
     * @return bool
     */
    public function missingFormat(): bool
    {
        return \is_null($this->format);
    }

    /**
     * Determine if the class has a format.
     *
     * @return bool
     */
    public function hasFormat(): bool
    {
        return ! $this->missingFormat();
    }
}
