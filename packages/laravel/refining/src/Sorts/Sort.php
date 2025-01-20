<?php

declare(strict_types=1);

namespace Honed\Refining\Sorts;

use Honed\Refining\Refiner;
use Laravel\Scout\Builder as ScoutBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Honed\Core\Concerns\IsDefault;

class Sort extends Refiner
{
    use IsDefault;

    /**
     * @var 'asc'|'desc'|null
     */
    protected $direction;

    /**
     * @var 'asc'|'desc'|null
     */
    protected $only;

    public function setUp()
    {
        $this->type('sort');
    }

    public function isActive(): bool
    {
        return $this->getValue() === $this->getParameter();
    }

    public function apply(Builder $builder, Request $request): void
    {
        if ($this->isActive()) {
            $this->handle($builder, $this->getDirection() ?? 'asc', $this->getParameter());
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     */
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
            'direction' => $this->getDirection(),
            'next' => $this->getNextDirection(),
        ]);
    }

    /**
     * @param 'asc'|'desc'|null $direction
     * @return $this
     */
    public function direction(?string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return 'asc'|'desc'|null
     */
    public function getDirection(): ?string
    {
        return $this->isSingularDirection() ? $this->only : $this->direction;
    }

    public function getNextDirection(): ?string
    {
        if ($this->isSingularDirection()) {
            return $this->only === 'desc' 
                ? $this->getDescendingValue() 
                : $this->getAscendingValue();
        }

        return match ($this->direction) {
            'desc' => null,
            'asc' => $this->getDescendingValue(),
            default => $this->getAscendingValue(),
        };
    }

    public function getDescendingValue(): string
    {
        return \sprintf('-%s', $this->getParameter());
    }

    public function getAscendingValue(): string
    {
        return $this->getParameter();
    }

    public function asc(): static
    {
        $this->only = 'asc';

        return $this;
    }

    public function desc(): static
    {
        $this->only = 'desc';

        return $this;
    }

    public function isSingularDirection(): bool
    {
        return ! \is_null($this->only);
    }
}
