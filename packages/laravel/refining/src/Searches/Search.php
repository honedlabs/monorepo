<?php

declare(strict_types=1);

namespace Honed\Refining\Searches;

use Honed\Refining\Refiner;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Search extends Refiner
{
    public function setUp()
    {
        $this->type('search');
    }

    public function isActive(): bool
    {
        return true;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @param array<int, string>|true $columns
     */
    public function apply(Builder $builder, Request $request, array|true $columns, bool $and): bool
    {
        $value = $this->getValueFromRequest($request);

        $this->value($value);

        if (!$this->isActive()) {
            return false;
        }

        /** @var string */
        $attribute = $this->getAttribute();

        $this->handle($builder, $value, $attribute);

        return true;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     */
    public function handle(Builder $builder, string $value, string $property): void
    {
        $builder->where(
            column: $builder->qualifyColumn($property),
            operator: 'like',
            value: '%'.$value.'%'
        );
    }
}

