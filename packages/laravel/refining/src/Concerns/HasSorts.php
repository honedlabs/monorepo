<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;

trait HasSorts
{
    /**
     * @var array<int,\Honed\Refining\Sorts\Sort>
     */
    protected $sorts;

    /**
     * @var string
     */
    protected $sortBy;

    /**
     * @param \Honed\Refining\Sorts\Sort|iterable<\Honed\Refining\Sorts\Sort> $sorts
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

    public function sort(Builder $builder): static
    {
        foreach ($this->getSorts() as $sort) {
            $sort->apply($builder, $this->getBuilder());
        }

        return $this;
    }
}
