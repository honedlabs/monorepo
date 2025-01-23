<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

use Honed\Core\Concerns\HasOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SetFilter extends Filter
{
    use HasOptions;
    use Concerns\IsMultiple;

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

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'options' => $this->getOptions(),
        ]);
    }
}