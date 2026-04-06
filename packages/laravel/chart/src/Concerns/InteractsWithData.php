<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

trait InteractsWithData
{
    /**
     * @var list<mixed>|null
     */
    protected $source;

    /**
     * @var list<mixed>|null
     */
    protected $data;

    /**
     * How the category (independent variable) should be determined. A string key
     * indicates a property on the source object to be plucked.
     *
     * @var string|(Closure():mixed)|null
     */
    protected $category;

    /**
     * How the value (dependent variable) should be determined. A string key
     * indicates a property on the source object to be plucked.
     *
     * @var string|(Closure():mixed)|null
     */
    protected $value;

    /**
     * Set the source of the data.
     *
     * @param  list<mixed>|Arrayable<int, mixed>  $source
     */
    public function from(array|Arrayable $source): static
    {
        return $this->source($source);
    }

    /**
     * Set the source of the data.
     *
     * @param  list<mixed>|Arrayable<int, mixed>|null  $source
     */
    public function source(array|Arrayable|null $source): static
    {
        if ($source === null) {
            $this->source = null;
        } elseif ($source instanceof Arrayable) {
            $this->source = array_values($source->toArray());
        } else {
            $this->source = $source;
        }

        return $this;
    }

    /**
     * Get the source of the data.
     *
     * @return list<mixed>|null
     */
    public function getSource(): ?array
    {
        return $this->source;
    }

    /**
     * Set how the category should be determined.
     *
     * @param  string|(Closure():mixed)|null  $value
     */
    public function category(string|Closure|null $value): static
    {
        $this->category = $value;

        return $this;
    }

    /**
     * Get how the category should be determined.
     *
     * @return string|(Closure():mixed)|null
     */
    public function getCategory(): string|Closure|null
    {
        return $this->category;
    }

    /**
     * Set how the value should be determined.
     *
     * @param  string|(Closure():mixed)|null  $value
     */
    public function value(string|Closure|null $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get how the value should be determined.
     *
     * @return string|(Closure():mixed)|null
     */
    public function getValue(): string|Closure|null
    {
        return $this->value;
    }

    /**
     * Set the data.
     *
     * @param  list<mixed>|Arrayable<int, mixed>  $value
     * @return $this
     */
    public function data(array|Arrayable $value): static
    {
        $this->data = $value instanceof Arrayable ? array_values($value->toArray()) : $value;

        return $this;
    }

    /**
     * Determine if the object has data already set.
     */
    public function hasData(): bool
    {
        return isset($this->data);
    }

    /**
     * Get the data.
     *
     * @return list<mixed>|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * Retrieve a set of values from a given source.
     *
     * @param  list<mixed>  $source
     * @param  string|(Closure():mixed)|null  $value
     * @return list<mixed>|null
     */
    public function retrieve(array $source, string|Closure|null $value): ?array
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value)) {
            /** @var list<mixed> */
            return Arr::pluck($source, $value);
        }

        /** @var list<mixed> */
        return Arr::map($source, $value);
    }
}
