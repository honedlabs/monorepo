<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

class StringFormatter implements Contracts\Formatter
{
    use Concerns\HasPrefix;
    use Concerns\HasSuffix;

    /**
     * Create a new string formatter instance with a prefix and suffix.
     *
     * @param  string|(\Closure():string)|null  $prefix
     * @param  string|(\Closure():string)|null  $suffix
     */
    public function __construct(string|\Closure|null $prefix = null, string|\Closure|null $suffix = null)
    {
        $this->setPrefix($prefix);
        $this->setSuffix($suffix);
    }

    /**
     * Make a string formatter with a prefix and suffix.
     *
     * @param  string|(\Closure():string)|null  $prefix
     * @param  string|(\Closure():string)|null  $suffix
     * @return $this
     */
    public static function make(string|\Closure|null $prefix = null, string|\Closure|null $suffix = null): static
    {
        return resolve(static::class, compact('prefix', 'suffix'));
    }

    /**
     * Format the value as a string
     */
    public function format(mixed $value): ?string
    {
        if (\is_null($value)) {
            return null;
        }

        return $this->getPrefix().$value.$this->getSuffix();
    }
}
