<?php

declare(strict_types=1);

namespace Honed\Refining\Sorts;

use Honed\Refining\Refiner;
use Honed\Core\Concerns\IsDefault;
use Illuminate\Database\Eloquent\Builder;

class Sort extends Refiner
{
    use IsDefault;

    /**
     * @var string|null
     */
    protected $direction;

    public function isActive(): bool
    {
        return $this->getValue();
    }

    public function apply(Builder $builder): void
    {
        $this->direction = $this->getSortDirection();

        if ($this->isActive()) {
            $this->handle($builder, $this->direction, $this->getParameter());
        }
    }

    public function handle(Builder $builder, string $direction, string $property): void
    {
        $builder->orderBy(
            column: $builder->qualifyColumn($property),
            direction: $direction,
        );
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'direction' => $this->getValue(),
            'next' => $this->getNextDirection(),
        ]);
    }
}
