<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

use Honed\Refining\Refiner;
use Honed\Core\Concerns\Validatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Filter extends Refiner
{
    use Validatable;

    protected string $mode = 'exact';
    protected string $operator = '=';
    
    public function apply(Builder $builder, Request $request): void
    {
        $value = $request->get($this->getParameter());

        $this->value($value);

        if ($this->isActive() && $this->validate($value)) {
            $this->handle($builder, $value, $this->getAttribute());
        }
    }

    public function handle(Builder $builder, mixed $value, string $property): void
    {
        $builder->{$this->getStatement()}(
            column: $builder->qualifyColumn($property),
            operator: $this->getOperator(),
            value: $value,
        );
    }

    public function isActive(): bool
    {
        return $this->hasValue();
    }

    /**
     * @return $this
     */
    public function mode(string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return $this
     */
    public function exact(): static
    {
        return $this->mode('exact');
    }

    /**
     * @return $this
     */
    public function like(): static
    {
        return $this->mode('like');
    }

    /**
     * @return $this
     */
    public function startsWith(): static
    {
        return $this->mode('starts_with');
    }

    /**
     * @return $this
     */
    public function endsWith(): static
    {
        return $this->mode('ends_with');
    }

    /**
     * @return $this
     */
    public function operator(string $operator): static
    {
        $this->operator = $operator;

        return $this;
    }
}
