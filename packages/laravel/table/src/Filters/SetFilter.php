<?php

declare(strict_types=1);

namespace Honed\Table\Filters;

use Illuminate\Http\Request;
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
        $this->setClause(Clause::Is);
        $this->setOperator(Operator::Equal);
        $this->setStrict(true);
    }

    public function isFiltering(mixed $value): bool
    {
        if (\is_null($value)) {
            return false;
        }

        // Check if the value is in the options
        $isFiltering = false;

        foreach ($this->getOptions() as $option) {
            if ($option->getValue() === $value) {
                $option->setActive(true);
                $isFiltering = true;
            } else {
                $option->setActive(false);
            }
        }

        return $isFiltering || ! $this->isStrict();
    }

    public function getValueFromRequest(Request $request = null): mixed
    {
        $input = ($request ?? request())
            ->input($this->getParameterName(), null);

        if (! \is_null($input) && $this->isMultiple()) {
            return \str_getcsv($input);
        }

        return $input;
    }

    public function handle(Builder $builder): void
    {
        match ($this->isMultiple()) {
            true => $builder->whereIn($this->getAttribute(), $this->getValue()),
            false => $this->getClause()->apply($builder, $this->getAttribute(), $this->getOperator(), $this->getValue()),
        };
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'options' => $this->getOptions(),
        ]);
    }
}
