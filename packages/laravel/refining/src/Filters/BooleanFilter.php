<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BooleanFilter extends Filter
{
    public function setUp(): void
    {
        $this->type('boolean');
    }

    public function handle(Builder $builder, mixed $value, string $property): void
    {
        $column = $builder->qualifyColumn($property);

        $builder->where(
            column: $column,
            operator: self::Is,
            value: $value,
            boolean: 'and'
        );
    }

    public function getValueFromRequest(Request $request): mixed
    {
        return \filter_var($request->input($this->getParameter()), \FILTER_VALIDATE_BOOLEAN, \FILTER_NULL_ON_FAILURE);
    }
}