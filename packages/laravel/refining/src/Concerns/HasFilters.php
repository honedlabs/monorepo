<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Arrayable;

trait HasFilters
{
    /**
     * @var array<int,\Honed\Refining\Filters\Filter>|null
     */
    protected $filters;

    /**
     * @param iterable<\Honed\Refining\Filters\Filter> $filters
     * @return $this
     */
    public function addFilters(iterable $filters): static
    {
        if ($filters instanceof Arrayable) {
            $filters = $filters->toArray();
        }

        /** @var array<int, \Honed\Refining\Filters\Filter> $filters */
        $this->filters = \array_merge($this->filters ?? [], $filters);

        return $this;
    }

    /**
     * @return array<int,\Honed\Refining\Filters\Filter>
     */
    public function getFilters(): array
    {
        return $this->filters ??= match (true) {
            \method_exists($this, 'filters') => $this->filters(),
            default => [],
        };
    }

    /**
     * @param Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @return $this
     */
    public function filter(Builder $builder, Request $request): static
    {
        foreach ($this->getFilters() as $filter) {
            $filter->apply($builder, $request);
        }

        return $this;
    }
}
