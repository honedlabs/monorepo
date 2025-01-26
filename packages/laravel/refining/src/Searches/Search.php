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

        if (! $this->isActive()) {
            return false;
        }

        $attribute = type($this->getAttribute())->asString();

        $value = type($value)->asString();

        $this->handle($builder, $value, $attribute, $and);

        return true;
    }

    public function getValueFromRequest(Request $request): ?string
    {
        $v = $request->string($this->getParameter())->toString();

        if (empty($v)) {
            return null;
        }

        return $v;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     */
    public function handle(Builder $builder, string $value, string $property, bool $boolean): void
    {
        $builder->where(
            column: $builder->qualifyColumn($property),
            operator: 'like',
            value: '%'.$value.'%',
            boolean: $boolean ? 'and' : 'or',
        );
    }
}

