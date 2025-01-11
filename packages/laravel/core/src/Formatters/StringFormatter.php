<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Honed\Core\Contracts\Formats;
use Illuminate\Support\Stringable;

class StringFormatter implements Formats
{
    /**
     * @var string|null
     */
    protected $prefix = null;

    /**
     * @var string|null
     */
    protected $suffix = null;

    /**
     * @var int|null
     */
    protected $limit = null;

    public function __construct(
        ?string $prefix = null,
        ?string $suffix = null,
        ?int $limit = null
    ) {
        $this->prefix($prefix);
        $this->suffix($suffix);
        $this->limit($limit);
    }

    /**
     * Make a new string formatter.
     */
    public static function make(
        ?string $prefix = null,
        ?string $suffix = null,
        ?int $limit = null
    ): static {
        return resolve(static::class, compact('prefix', 'suffix', 'limit'));
    }

    /**
     * Set the prefix for the instance.
     *
     * @return $this
     */
    public function prefix(?string $prefix = null): static
    {
        if (! \is_null($prefix)) {
            $this->prefix = $prefix;
        }

        return $this;
    }

    /**
     * Get the prefix for the instance.
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * Determine if the instance has a prefix set.
     */
    public function hasPrefix(): bool
    {
        return ! \is_null($this->prefix);
    }

    /**
     * Get or set the suffix for the instance.
     *
     * @return $this
     */
    public function suffix(?string $suffix = null): static
    {
        if (! \is_null($suffix)) {
            $this->suffix = $suffix;
        }

        return $this;
    }

    /**
     * Get the suffix for the instance.
     */
    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    /**
     * Determine if the instance has a suffix set.
     */
    public function hasSuffix(): bool
    {
        return ! \is_null($this->suffix);
    }

    /**
     * Get or set the limit for the instance.
     *
     * @return $this
     */
    public function limit(?int $limit = null): static
    {
        if (! \is_null($limit)) {
            $this->limit = $limit;
        }

        return $this;
    }

    /**
     * Get the limit for the instance.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Determine if the instance has a limit set.
     */
    public function hasLimit(): bool
    {
        return ! \is_null($this->limit);
    }

    /**
     * Format the value as a string.
     */
    public function format(mixed $value): ?string
    {
        if (\is_null($value)) {
            return null;
        }

        return str((string) $value)
            ->when($this->hasLimit(),
                fn (Stringable $str) => $str->limit($this->getLimit())) // @phpstan-ignore-line
            ->when($this->hasPrefix(),
                fn (Stringable $str) => $str->prepend($this->getPrefix())) // @phpstan-ignore-line
            ->when($this->hasSuffix(),
                fn (Stringable $str) => $str->append($this->getSuffix())) // @phpstan-ignore-line
            ->toString();
    }
}
