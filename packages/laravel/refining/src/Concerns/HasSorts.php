<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Honed\Refining\Sorts\Sort;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasSorts
{
    /**
     * @var array<int,\Honed\Refining\Sorts\Sort>
     */
    protected $sorts;

    protected string $sortKey = 'sort';

    /**
     * @param iterable<\Honed\Refining\Sorts\Sort> $sorts
     * @return $this
     */
    public function addSorts(iterable $sorts): static
    {
        if ($sorts instanceof Arrayable) {
            $sorts = $sorts->toArray();
        }

        $this->sorts = \array_merge($this->sorts, $sorts);

        return $this;
    }

    /**
     * @return array<int,\Honed\Refining\Sorts\Sort>
     */
    public function getSorts(): array
    {
        return $this->sorts ??= match (true) {
            \method_exists($this, 'sorts') => $this->sorts(),
            default => [],
        };
    }

    /**
     * @return $this
     */
    public function sort(Builder $builder, Request $request): static
    {
        foreach ($this->getSorts() as $sort) {
            $sort->apply($builder, $this->getBuilder());
        }

        return $this;
    }

    /**
     * Sets the sort key to look for in the request.
     */
    public function sortKey(string $sortKey): static
    {
        $this->sortKey = $sortKey;

        return $this;
    }

    /**
     * Gets the sort key to look for in the request.
     */
    public function getSortKey(): string
    {
        return $this->sortKey;
    }
}
