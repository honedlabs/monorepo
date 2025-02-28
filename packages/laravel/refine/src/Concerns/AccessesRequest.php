<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Core\Concerns\HasRequest;
use Honed\Core\Concerns\HasScope;

trait AccessesRequest
{
    use HasRequest;
    use HasScope;

    /**
     * The delimiter for accessing arrays.
     * 
     * @var string|null
     */
    protected $delimiter;

    /**
     * Set the delimiter for accessing arrays.
     * 
     * @return $this
     */
    public function delimiter(string $delimiter): static
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * Get the delimiter for accessing arrays.
     */
    public function getDelimiter(): string
    {
        return $this->delimiter ?? $this->getFallbackDelimiter();
    }

    /**
     * Get the fallback delimiter for accessing arrays.
     */
    protected function getFallbackDelimiter(): string
    {
        return type(config('refine.delimiter', ','))->asString();
    }

    /**
     * Get a query parameter from the request using the current scope.
     */
    public function getScopedQueryParameter(string $parameter): mixed
    {
        $scoped = $this->formatScope($parameter);

        return $this->getQueryParameter($scoped);
    }

    /**
     * Use the delimiter to extract an array of values from a query parameter.
     * 
     * @return array<int,string>|null
     */
    public function getArrayFromQueryParameter(string $parameter): ?array
    {
        $values = str($this->getScopedQueryParameter($parameter));

        if ($values->isEmpty()) {
            return null;
        }

        return $values
            ->explode($this->getDelimiter())
            ->map(\trim(...))
            ->toArray();
    }
}