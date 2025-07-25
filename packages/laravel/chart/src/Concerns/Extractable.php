<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait Extractable
{
    /**
     * The strategy to use for extracting data.
     * 
     * @var string|null
     */
    protected $extractStrategy;

    public function property(string $property): static
    {

    }

    public function call(string $method, ...$parameters): static
    {

    }

    public function pluck(string $key): static
    {
        return $this;
    }

    public function from(str)
}