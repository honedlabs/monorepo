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

    /**
     * Make a new string formatter.
     *
     * @param  string|null  $prefix
     * @param  string|null  $suffix
     * @param  int|null  $limit
     * @return static
     */
    public static function make($prefix = null, $suffix = null, $limit = null)
    {
        return resolve(static::class)
            ->prefix($prefix)
            ->suffix($suffix)
            ->limit($limit);
    }

    /**
     * Set the prefix for the instance.
     *
     * @param  string|null  $prefix
     * @return $this
     */
    public function prefix($prefix = null)
    {
        if (! \is_null($prefix)) {
            $this->prefix = $prefix;
        }

        return $this;
    }

    /**
     * Get the prefix for the instance.
     *
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Determine if the instance has a prefix set.
     *
     * @return bool
     */
    public function hasPrefix()
    {
        return ! \is_null($this->prefix);
    }

    /**
     * Get or set the suffix for the instance.
     *
     * @param  string|null  $suffix
     * @return $this
     */
    public function suffix($suffix = null)
    {
        if (! \is_null($suffix)) {
            $this->suffix = $suffix;
        }

        return $this;
    }

    /**
     * Get the suffix for the instance.
     *
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Determine if the instance has a suffix set.
     *
     * @return bool
     */
    public function hasSuffix()
    {
        return ! \is_null($this->suffix);
    }

    /**
     * Get or set the limit for the instance.
     *
     * @param  int|null  $limit
     * @return $this
     */
    public function limit($limit = null)
    {
        if (! \is_null($limit)) {
            $this->limit = $limit;
        }

        return $this;
    }

    /**
     * Get the limit for the instance.
     *
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Determine if the instance has a limit set.
     *
     * @return bool
     */
    public function hasLimit()
    {
        return ! \is_null($this->limit);
    }

    /**
     * Format the value as a string.
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function format($value)
    {
        if (\is_null($value)) {
            return null;
        }

        /** @var string $value */
        return str($value)
            ->when($this->hasLimit(),
                fn (Stringable $str) => $str->limit($this->getLimit())) // @phpstan-ignore-line
            ->when($this->hasPrefix(),
                fn (Stringable $str) => $str->prepend($this->getPrefix())) // @phpstan-ignore-line
            ->when($this->hasSuffix(),
                fn (Stringable $str) => $str->append($this->getSuffix())) // @phpstan-ignore-line
            ->toString();
    }
}
