<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Honed\Data\Contracts\QueryRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Intervention\Validation\AbstractRule;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
class RecordExists extends AbstractRule
{
    /**
     * @param class-string<TModel|QueryRule<TModel, TBuilder>>|TBuilder|TModel|QueryRule<TModel, TBuilder> $query
     */
    public function __construct(
        protected string|Builder|Model|QueryRule $query,
        protected ?string $column = null,
    ) { }

    /**
     * Checks if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        return count((array) $value) === $this->countRecords($value);
    }

    /**
     * Resolve the query builder to utilise.
     * 
     * @return TBuilder
     */
    protected function resolveQuery(): Builder
    {
        if (is_string($this->query)) {
            $this->query = resolve($this->query);
        }

        /** @var TBuilder */
        return match (true) {
            $this->query instanceof QueryRule => $this->query->query(),
            $this->query instanceof Model => $this->query->newQuery(),
            default => $this->query,
        };
    }

    /**
     * Get the number of records that exist in the database which match the query.
     */
    protected function countRecords(mixed $value): int
    {
        return tap($this->resolveQuery(), fn (Builder $query) => match (true) {
            ! $this->column => $query->whereKey($value),
            ! is_array($value) => $query->where($query->qualifyColumn($this->column), $value),
            in_array($query->getModel()->getKeyType(), ['int', 'integer']) => $query->whereIntegerInRaw($query->qualifyColumn($this->column), $value),
            default => $query->whereIn($query->qualifyColumn($this->column), $value),
        })->count();
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'record_exists';
    }
}