<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

use Honed\Core\Concerns\HasOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SetFilter extends Filter
{
    use HasOptions;

    protected bool $multiple = false;

    public function setUp(): void
    {
        $this->type('set');
    }

    /**
     * @param Carbon\Carbon $value
     */
    public function handle(Builder $builder, mixed $value, string $property): void
    {
        $column = $builder->qualifyColumn($property);

        $builder->whereDate(
            column: $column,
            operator: self::Is,
            value: $value,
            boolean: 'and'
        );
    }

    /**
     * @return $this
     */
    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;

        return $this;   
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }
}