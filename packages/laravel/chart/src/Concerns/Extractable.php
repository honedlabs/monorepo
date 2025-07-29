<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Illuminate\Support\Arr;
use RuntimeException;

trait Extractable
{
    use HasData;

    protected const VALUE = 'value';
    protected const PROPERTY = 'property';
    protected const PLUCK = 'pluck';
    protected const CALLBACK = 'callback';

    /**
     * The strategy to use for extracting data.
     * 
     * @var string|null
     */
    protected $extract;

    /**
     * The extractor.
     * 
     * @var mixed
     */
    protected $extractor;

    /**
     * Set the extractor to use a fixed value.
     * 
     * @return $this
     */
    public function values(mixed $value): static
    {
        $this->extract = self::VALUE;
        
        $this->extractor = $value;
        
        return $this;
    }

    /**
     * Set the extractor to use the specified property.
     * 
     * @return $this
     */
    public function property(string $value): static
    {
        $this->extract = self::PROPERTY;

        $this->extractor = $value;

        return $this;
    }

    /**
     * Set the extractor to use the specified key.
     * 
     * @return $this
     */
    public function pluck(string $value): static
    {
        $this->extract = self::PLUCK;

        $this->extractor = $value;

        return $this;
    }

    /**
     * Set the extractor to use the specified callback.
     * 
     * @param (Closure(mixed): mixed) $value
     * @return $this
     */
    public function callback(Closure $value): static
    {
        $this->extract = self::CALLBACK;

        $this->extractor = $value;

        return $this;
    }

    /**
     * Retrieve the data using the specified extractor.
     */
    public function extract(mixed $data): mixed
    {
        return match ($this->extract) {
            self::PLUCK => Arr::get($data, $this->extractor),
            self::PROPERTY => $data->{$this->extractor},
            self::CALLBACK => ($this->extractor)($data),
            self::VALUE => $this->extractor,
            default => throw new RuntimeException(
                'You must specify an extractor for the component ['.static::class.'], otherwise the data will be empty.'
            ),
        };
    }
}