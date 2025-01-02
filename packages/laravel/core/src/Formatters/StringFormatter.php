<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Honed\Core\Concerns\Evaluable;
use Illuminate\Support\Str;

class StringFormatter implements Contracts\Formatter
{
    use Concerns\HasPrefix;
    use Concerns\HasSuffix;
    use Concerns\Truncates;
    use Evaluable;

    /**
     * Create a new string formatter instance with a prefix and suffix.
     *
     * @param  string|(\Closure():string)|null  $prefix
     * @param  string|(\Closure():string)|null  $suffix
     */
    public function __construct(string|\Closure|null $prefix = null, string|\Closure|null $suffix = null, int $truncate = null)
    {
        $this->setPrefix($prefix);
        $this->setSuffix($suffix);
        $this->setTruncate($truncate);
    }

    /**
     * Make a string formatter with a prefix and suffix.
     *
     * @param  string|(\Closure():string)|null  $prefix
     * @param  string|(\Closure():string)|null  $suffix
     * @return $this
     */
    public static function make(string|\Closure|null $prefix = null, string|\Closure|null $suffix = null, int $truncate = null): static
    {
        return resolve(static::class, compact('prefix', 'suffix', 'truncate'));
    }

    /**
     * Format the value as a string
     */
    public function format(mixed $value): ?string
    {
        if (\is_null($value)) {
            return null;
        }

        $value = (string) $value;

        if ($this->hasTruncate()) {
            $value = Str::limit($value, (int) $this->getTruncate());
        }

        return $this->getPrefix().$value.$this->getSuffix();
    }
}
