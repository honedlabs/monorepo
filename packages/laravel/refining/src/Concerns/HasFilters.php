<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Arrayable;

trait HasFilters
{
    /**
     * @var array<int,\Honed\Refining\Filters\Filter>
     */
    protected $filters = [];

    /**
     * @param \Honed\Refining\Filters\Filter|iterable<\Honed\Refining\Filters\Filter> $filters
     * @return $this
     */
    public function addFilters(iterable $filters): static
    {
        if ($filters instanceof Arrayable) {
            $filters = $filters->toArray();
        }

        $this->filters = \array_merge($this->filters, $filters);

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
     * @return $this
     */
    public function filter(Builder $builder): static
    {
        foreach ($this->getFilters() as $filter) {
            $filter->apply($builder);
        }

        return $this;
    }
}
