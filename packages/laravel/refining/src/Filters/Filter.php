<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

use Honed\Refining\Refiner;
use Honed\Core\Concerns\Validatable;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class Filter extends Refiner
{
    use Validatable;

    protected string $mode = 'exact';
    protected string $operator = '=';
    
    public function apply(Builder $builder, Request $request): void
    {
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

    public function exact()
    {

    }

    public function like()
    {

    }

    public function startsWith()
    {

    }

    public function endsWith()
    {

    }

    public function operator()
    {

    }

    public function 

}
