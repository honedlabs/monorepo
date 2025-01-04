<?php

declare(strict_types=1);

namespace Honed\Table\Filters;

use Illuminate\Http\Request;
use Honed\Core\Options\Option;
use Honed\Core\Concerns\IsStrict;
use Honed\Table\Filters\Enums\Clause;
use Honed\Table\Filters\Enums\Operator;
use Illuminate\Database\Eloquent\Builder;
use Honed\Core\Options\Concerns\HasOptions;

class SetFilter extends BaseFilter
{
    use Concerns\HasClause;
    use Concerns\HasOperator;
    use Concerns\IsMultiple;
    use HasOptions;
    use IsStrict;

    public function setUp(): void
    {
        $this->setType('filter:set');
        $this->setClause(Clause::Contains);
        $this->setOperator(Operator::Equal);
        $this->setStrict(true);
    }

    public function isFiltering(mixed $value): bool
    {
        if (\is_null($value)) {
            return false;
        }

        if (! $this->hasOptions()) {
            return true;
        }

        $filtering = $this->collectOptions()->reduce(
            static fn (bool $filtering, Option $option) => $option
                ->active($option->getValue() === $value)
                ->isActive() || $filtering,
            false
        );

        return $this->isStrict() 
            ? $filtering : true;
    }

    public function getValueFromRequest(Request $request = null): mixed
    {
        $input = ($request ?? request())
            ->input($this->getParameterName(), null);

        return ! \is_null($input) && $this->isMultiple()
            ? \str_getcsv((string) $input)
            : $input;
    }

    public function handle(Builder $builder): void
    {
        match (true) {
            ! $this->isMultiple() => $this->getClause()
                ->apply($builder, 
                    $this->getAttribute(), 
                    $this->getOperator(), 
                    $this->getValue()
                ),
            $this->getOperator() === Operator::NotEqual => $builder->whereNotIn(
                $this->getAttribute(), 
                $this->getValue()
            ),
            default => $builder->whereIn(
                $this->getAttribute(), 
                $this->getValue()
            ),
        };
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'options' => $this->getOptions(),
        ]);
    }
}
