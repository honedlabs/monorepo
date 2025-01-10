<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Honed\Core\Contracts\Formats;
use Illuminate\Support\Stringable;

class StringFormatter implements Formats
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var int
     */
    protected $limit;

    /**
     * Create a new string formatter instance with a prefix and suffix.
     *
     * @param string|null $prefix
     * @param string|null $suffix
     * @param int|null $limit
     */
    public function __construct($prefix = null, $suffix = null, $limit = null)
    {
        $this->prefix($prefix);
        $this->suffix($suffix);
        $this->limit($limit);
    }

    /**
     * Make a string formatter with a prefix and suffix.
     *
     * @param string|null $prefix
     * @param string|null $suffix
     * @param int|null $limit
     * 
     * @return static
     */
    public static function make($prefix = null, $suffix = null, $limit = null)
    {
        return resolve(static::class, compact('prefix', 'suffix', 'limit'));
    }

    /**
     * Get or set the prefix for the instance.
     * 
     * @param string|null $prefix The prefix to set, or null to retrieve the current prefix.
     * @return string|null|$this The current prefix when no argument is provided, or the instance when setting the prefix.
     */
    public function prefix($prefix = null)
    {
        if (\is_null($prefix)) {
            return $this->prefix;
        }

        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Determine if the instance has a prefix set.
     * 
     * @return bool True if a prefix is set, false otherwise.
     */
    public function hasPrefix()
    {
        return ! \is_null($this->prefix);
    }

    /**
     * Get or set the suffix for the instance.
     * 
     * @param string|null $suffix The suffix to set, or null to retrieve the current suffix.
     * @return string|null|$this The current suffix when no argument is provided, or the instance when setting the suffix.
     */
    public function suffix($suffix = null)
    {
        if (\is_null($suffix)) {
            return $this->suffix;
        }

        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Determine if the instance has a suffix set.
     * 
     * @return bool True if a suffix is set, false otherwise.
     */
    public function hasSuffix()
    {
        return ! \is_null($this->suffix);
    }

    /**
     * Get or set the limit for the instance.
     * 
     * @param int|null $limit The limit to set, or null to retrieve the current limit.
     * @return int|null|$this The current limit when no argument is provided, or the instance when setting the limit.
     */
    public function limit($limit = null)
    {
        if (\is_null($limit)) {
            return $this->limit;
        }

        $this->limit = $limit;

        return $this;
    }

    /**
     * Determine if the instance has a limit set.
     * 
     * @return bool True if a limit is set, false otherwise.
     */
    public function hasLimit()
    {
        return ! \is_null($this->limit);
    }

    /**
     * Format the value as a string
     * 
     * @param mixed $value
     * @return string|null
     */
    public function format($value)
    {
        if (\is_null($value)) {
            return null;
        }

        return (str((string) $value))
            ->when($this->hasLimit(), 
                fn (Stringable $str) => $str->limit($this->limit()))
            ->when($this->hasPrefix(), 
                fn (Stringable $str) => $str->prepend($this->prefix()))
            ->when($this->hasSuffix(), 
                fn (Stringable $str) => $str->append($this->suffix()))
            ->toString();
    }
}
