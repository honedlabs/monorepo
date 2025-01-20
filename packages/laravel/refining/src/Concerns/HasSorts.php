<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Honed\Refining\Sorts\Sort;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait HasSorts
{
    /**
     * @var array<int,\Honed\Refining\Sorts\Sort>|null
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
        
        /** @var array<int, \Honed\Refining\Sorts\Sort> $sorts */
        $this->sorts = \array_merge($this->sorts ?? [], $sorts);

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
     * @param Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @return $this
     */
    public function sort(Builder $builder, Request $request): static
    {
        [$name, $direction] = $this->getSortFromRequest($request);

        foreach ($this->getSorts() as $sort) {
            $sort->value($name)->direction($direction)->apply($builder);
        }

        return $this;
    }
    
    /**
     * Get the sort name and direction from the request.
     *
     * @return array{0: string|null, 1: 'asc'|'desc'|null}
     */
    public function getSortFromRequest(Request $request): array
    {
        $sort = $request->string($this->getSortKey());

        return match (true) {
            $sort->isEmpty() => [null, null],
            $sort->startsWith('-') => [$sort->after('-')->toString(), 'desc'],
            default => [$sort->toString(), 'asc'],
        };
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
