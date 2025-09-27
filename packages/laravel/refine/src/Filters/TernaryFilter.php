<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

use Closure;
use Honed\Refine\Option;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Filters\Filter<TModel, TBuilder>
 */
class TernaryFilter extends Filter
{
    /**
     * The label for the default option.
     * 
     * @var string
     */
    protected $blankLabel = 'All';

    /**
     * The query to apply when the placeholder is selected.
     * 
     * @var (\Closure(TModel):mixed)|null
     */
    protected $blankQuery = null;

    /**
     * The label for the true option.
     * 
     * @var string
     */
    protected $trueLabel = 'True';

    /**
     * The query to apply when the true option is selected.
     * 
     * @var (\Closure(TModel):mixed)|null
     */
    protected $trueQuery = null;
    
    /**
     * The label for the false option.
     * 
     * @var string
     */
    protected $falseLabel = 'False';

    /**
     * The query to apply when the false option is selected.
     * 
     * @var (\Closure(TModel):mixed)|null
     */
    protected $falseQuery = null;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('select');

        $this->query(fn (Builder $query, $value) => match ($value) {
            'true' => $this->callTrueQuery($query),
            'false' => $this->callFalseQuery($query),
            default => $this->callBlankQuery($query),
        });
    }

    /**
     * Set the label for the blank option.
     * 
     * @param string $label
     * @return $this
     */
    public function blankLabel(string $label): static
    {
        $this->blankLabel = $label;

        return $this;
    }

    /**
     * Get the label for the blank option.
     * 
     * @return string
     */
    public function getBlankLabel(): string
    {
        return $this->blankLabel;
    }

    /**
     * Set the query to apply when the blank is selected.
     * 
     * @param (\Closure(TModel):mixed)|null $query
     * @return $this
     */
    public function blankQuery(?Closure $query): static
    {
        $this->blankQuery = $query;

        return $this;
    }

    /**
     * Get the query to apply when the blank is selected.
     * 
     * @return (\Closure(TModel):mixed)|null
     */
    public function getBlankQuery(): ?Closure
    {
        return $this->blankQuery;
    }

    /**
     * Execute the query to apply when the blank is selected.
     * 
     * @param TModel $model
     * @return mixed
     */
    public function callBlankQuery(Builder $builder): mixed
    {
        $callback = $this->getBlankQuery() 
            ?? fn (Builder $query) => $query;

        return $callback($builder);
    }

    /**
     * Set the label for the true option.
     * 
     * @param string $label
     * @return $this
     */
    public function trueLabel(string $label): static
    {
        $this->trueLabel = $label;
        
        return $this;
    }

    /**
     * Get the label for the true option.
     * 
     * @return string
     */
    public function getTrueLabel(): string
    {
        return $this->trueLabel;
    }

    /**
     * Set the query to apply when the true option is selected.
     * 
     * @param (\Closure(TModel):mixed)|null $query
     * @return $this
     */
    public function trueQuery(?Closure $query): static
    {
        $this->trueQuery = $query;

        return $this;
    }

    /**
     * Get the query to apply when the true option is selected.
     * 
     * @return (\Closure(TModel):mixed)|null
     */
    public function getTrueQuery(): ?Closure
    {
        return $this->trueQuery;
    }

    /**
     * Execute the query to apply when the true option is selected.
     * 
     * @param TModel $model
     * @return mixed
     */
    public function callTrueQuery(Builder $builder): mixed
    {
        $callback = $this->getTrueQuery() 
            ?? fn (Builder $query) => $query->where($this->getQualifiedAttribute($query), true);

        return $callback($builder);
    }

    /**
     * Set the label for the false option.
     * 
     * @param string $label
     * @return $this
     */
    public function falseLabel(string $label): static
    {
        $this->falseLabel = $label;
        
        return $this;
    }

    /**
     * Get the label for the false option.
     * 
     * @return string
     */
    public function getFalseLabel(): string
    {
        return $this->falseLabel;
    }

    /**
     * Set the query to apply when the false option is selected.
     * 
     * @param (\Closure(TModel):mixed)|null $query
     * @return $this
     */
    public function falseQuery(?Closure $query): static
    {
        $this->falseQuery = $query;

        return $this;
    }

    /**
     * Get the query to apply when the false option is selected.
     * 
     * @return (\Closure(TModel):mixed)|null
     */
    public function getFalseQuery(): ?Closure
    {
        return $this->falseQuery;
    }

    /**
     * Execute the query to apply when the false option is selected.
     * 
     * @param TModel $model
     * @return mixed
     */
    public function callFalseQuery(Builder $builder): mixed
    {
        $callback = $this->getFalseQuery() 
            ?? fn (Builder $query) => $query->where($this->getQualifiedAttribute($query), false);

        return $callback($builder);
    }

    /**
     * Set how the query should change for each state of the ternary filter.
     * 
     * @param (\Closure(TModel):mixed)|null $true
     * @param (\Closure(TModel):mixed)|null $false
     * @param (\Closure(TModel):mixed)|null $blank
     * @return $this
     */
    public function queries(
        ?Closure $true = null,
        ?Closure $false = null,
        ?Closure $blank = null
    ): static {

        $this->trueQuery($true);
        $this->falseQuery($false);
        $this->blankQuery($blank);

        return $this;
    }

    /**
     * Get the options for the filter.
     * 
     * @return array<int, \Honed\Refine\Option>
     */
    public function getOptions(): array
    {
        return [
            Option::make('blank', $this->getBlankLabel()),
            Option::make('true', $this->getTrueLabel()),
            Option::make('false', $this->getFalseLabel()),
        ];
    }
}