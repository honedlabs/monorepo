<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Illuminate\Contracts\Support\Arrayable;

trait InteractsWithData
{
    /**
     * @var list<array<string, mixed>|Arrayable<string, mixed>|object>|null
     */
    protected $source;

    /**
     * @var list<mixed>
     */
    protected $data;

    /**
     * How the category (independent variable) should be determined. A string key
     * indicates a property on the source object to be plucked.
     * 
     * @var string|Closure():mixed
     */
    protected $category;

    /**
     * How the value (dependent variable) should be determined. A string key
     * indicates a property on the source object to be plucked.
     * 
     * @var string|Closure():mixed
     */
    protected $value;

    /**
     * Set the source of the data.
     * 
     * @template T of array<string, mixed>|Arrayable<string, mixed>|object
     * 
     * @param list<T>|Arrayable<int, T> $value
     * @return $this
     */
    public function from(array|Arrayable $source): static
    {
        return $this->source($source);
    }

    /**
     * Set the source of the data.
     * 
     * @template T of array<string, mixed>|Arrayable<string, mixed>|object
     * 
     * @param list<T>|Arrayable<int, T>|null $value
     */
    public function source(array|Arrayable|null $value): static
    {
        $this->source = $value instanceof Arrayable ? $value->toArray() : $value;

        return $this;
    }

    /**
     * Get the source of the data.
     * 
     * @return list<array<string, mixed>|Arrayable<string, mixed>|object>|null
     */
    public function getSource(): ?array
    {
        return $this->source;
    }

    /**
     * Set how the category should be determined.
     * 
     * @param string|Closure():mixed $value
     * @return $this
     */
    public function category(string|Closure $value): static
    {
        $this->category = $value;

        return $this;
    }

    /**
     * Get how the category should be determined.
     * 
     * @return string|Closure():mixed
     */
    public function getCategory(): string|Closure
    {
        return $this->category;
    }

    /**
     * Set how the value should be determined.
     * 
     * @param string|Closure():mixed $value
     * @return $this
     */
    public function value(string|Closure $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get how the value should be determined.
     * 
     * @return string|Closure():mixed
     */
    public function getValue(): string|Closure
    {
        return $this->value;
    }

    /**
     * Set the data.
     * 
     * @param list<mixed>|Arrayable<int, mixed> $value
     * @return $this
     */
    public function data(array|Arrayable $value): static
    {
        $this->data = $value instanceof Arrayable ? $value->toArray() : $value;

        return $this;

    }

    /**
     * Get the data.
     * 
     * @return list<mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }
}