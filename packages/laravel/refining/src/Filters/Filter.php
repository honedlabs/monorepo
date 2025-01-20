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

    const Not = '!=';
    const GreaterThan = '>';
    const LessThan = '<';
    const Exact = 'exact';
    const Like = 'like';
    const StartsWith = 'starts_with';
    const EndsWith = 'ends_with';

    protected string $mode = self::Exact;

    protected string $operator = '=';

    public function setUp(): void
    {
        $this->type('filter');
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'value' => $this->getValue(),
        ]);
    }
    
    public function apply(Builder $builder, Request $request): void
    {
        /** @var string|int|float|null */
        $value = $request->input($this->getParameter());

        $this->value($value);

        if ($this->isActive() && $this->validate($value)) {
            /** @var string */
            $attribute = $this->getAttribute();
            $this->handle($builder, $value, $attribute);
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @param string|int|float|bool|null $value
     */
    public function handle(Builder $builder, mixed $value, string $property): void
    {
        $column = $builder->qualifyColumn($property);

        if ($this->getMode() === self::Exact) {
            $builder->where(
                column: $column,
                operator: $this->getOperator(),
                value: $value,
                boolean: 'and'
            );

            return;
        }

        $operator = match (\mb_strtolower($operator = $this->getOperator())) {
            '=', 'like' => 'LIKE',
            '!=', 'not like' => 'NOT LIKE',
            default => throw new \InvalidArgumentException("Invalid operator [{$operator}] provided for [{$property}] filter.")
        };

        $sql = match ($this->getMode()) {
            self::StartsWith => "{$column} {$operator} ?",
            self::EndsWith => "{$column} {$operator} ?",
            default => "LOWER({$column}) {$operator} ?",
        };

        $bindings = match ($this->getMode()) {
            self::StartsWith => ["{$value}%"],
            self::EndsWith => ["%{$value}"],
            default => ['%' . mb_strtolower((string) $value, 'UTF8') . '%'],
        };

        $builder->whereRaw(
            sql: $sql,
            bindings: $bindings,
            boolean: 'and'
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
        return $this->mode(static::Exact);
    }

    /**
     * @return $this
     */
    public function like(): static
    {
        return $this->mode(static::Like);
    }

    /**
     * @return $this
     */
    public function startsWith(): static
    {
        return $this->mode(static::StartsWith);
    }

    /**
     * @return $this
     */
    public function endsWith(): static
    {
        return $this->mode(static::EndsWith);
    }

    /**
     * @return $this
     */
    public function operator(string $operator): static
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return $this
     */
    public function not(): static
    {
        return $this->operator(static::Not);
    }

    /**
     * @return $this
     */
    public function gt(): static
    {
        return $this->operator(static::GreaterThan);
    }

    /**
     * @return $this
     */
    public function lt(): static
    {
        return $this->operator(static::LessThan);
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}
