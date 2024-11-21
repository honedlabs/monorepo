<?php

declare(strict_types=1);

namespace Honed\Table\Filters;

use Honed\Table\Filters\Concerns\HasClause;
use Honed\Table\Filters\Concerns\HasOperator;
use Honed\Table\Filters\Concerns\HasOperators;
use Honed\Table\Filters\Enums\Clause;
use Honed\Table\Filters\Enums\Operator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Request;

class OperatorFilter extends PropertyFilter
{
    use HasClause;
    use HasOperator;
    use HasOperators;

    public function setUp(): void
    {
        $this->setType('operator');
        $this->setClause(Clause::Is);
    }

    public function getOperatorFromRequest(): ?Operator
    {
        $q = Request::input('['.$this->getName().']');

        return Operator::tryFrom($q);
    }

    public function apply(Builder|QueryBuilder $builder): void
    {
        $value = $this->applyTransform($this->getValueFromRequest());
        $this->setOperator($this->getOperatorFromRequest());
        $this->setValue($value);
        $this->setActive($this->filtering($value));

        $builder->when(
            $this->isActive() && $this->isValid($value),
            fn (Builder|QueryBuilder $builder) => $this->handle($builder),
        );
    }

    public function handle(Builder|QueryBuilder $builder): void
    {
        $this->getClause()
            ->apply($builder,
                $this->getProperty(),
                $this->getOperator(),
                $this->getValue()
            );
    }

    public function filtering(mixed $value): bool
    {
        return parent::filtering($value) &&
            collect($this->getOperators())->some(fn ($operator) => $operator->value === $this->getOperator()?->value);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'operators' => $this->getOperatorOptions($this->getOperator()?->value)->toArray(),
        ]);
    }
}
