<?php

declare(strict_types=1);

namespace Honed\Refine;

use Honed\Core\Concerns\HasBuilderInstance;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Concerns\HasScope;
use Honed\Core\Primitive;
use Honed\Refine\Filters\Filter;
use Honed\Refine\Searches\Search;
use Honed\Refine\Sorts\Sort;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder<TModel>
 * @extends Primitive<string, mixed>
 */
class Refine extends Primitive
{
    use Concerns\HasFilters;
    use Concerns\HasSearches;
    use Concerns\HasSorts;
    use ForwardsCalls;
    use HasBuilderInstance;
    use HasRequest;
    use HasScope;

    /**
     * @var bool
     */
    protected $refined = false;

    public function __construct(Request $request)
    {
        $this->request($request);
    }

    /**
     * Mark the refine pipeline as refined.
     * 
     * @return $this
     */
    protected function markAsRefined(): static
    {
        $this->refined = true;

        return $this;
    }

    /**
     * Determine if the refine pipeline has been run.
     */
    public function isRefined(): bool
    {
        return $this->refined;
    }

    /**
     * Dynamically handle calls to the class.
     * 
     * @param  string  $name
     * @param  array<int, mixed>  $arguments
     */
    public function __call($name, $arguments): mixed
    {
        /** @var array<int, Sort> $arguments */
        if ($name === 'sorts') {
            return $this->addSorts($arguments);
        }

        /** @var array<int, Filter> $arguments */
        if ($name === 'filters') {
            return $this->addFilters($arguments);
        }

        /** @var array<int, Search> $arguments */
        if ($name === 'searches') {
            return $this->addSearches($arguments);
        }

        // Delay the refine call until records are retrieved
        return $this->refine()
            ->forwardDecoratedCallTo(
                $this->getBuilder(),
                $name,
                $arguments
            );
    }

    /**
     * Create a new refine instance.
     * 
     * @param  TModel|class-string<TModel>|\Illuminate\Database\Eloquent\Builder<TModel>  $query
     */
    public static function make(mixed $query): static
    {
        $query = static::createBuilder($query);

        return resolve(static::class)->builder($query);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'sorts' => $this->sortsToArray(),
            'filters' => $this->filtersToArray(),
            ...($this->canMatch() ? ['searches' => $this->searchesToArray()] : []),
            'config' => $this->configToArray(),
        ];
    }

    /**
     * Get the config for the refiner as an array.
     *
     * @return array<string,mixed>
     */
    public function configToArray(): array
    {
        return [
            'search' => $this->getSearchValue(),
            'searches' => $this->getSearchesKey(),
            'sorts' => $this->getSortsKey(),
            ...($this->canMatch() ? ['matches' => $this->getMatchesKey()] : []),
        ];
    }

    /**
     * Refine the builder using the provided refinements.
     *
     * @return $this
     */
    public function refine(): static
    {
        if ($this->isRefined()) {
            return $this;
        }

        $this->pipe([
            'search',
            'sort',
            'filter',
        ]);

        return $this->markAsRefined();
    }

    /**
     * Pipe the builder through a series of methods.
     *
     * @param  array<int,string>  $pipes
     * @return $this
     */
    public function pipe(array $pipes): static
    {
        $builder = $this->getBuilder();
        $request = $this->getRequest();

        foreach ($pipes as $pipe) {
            $this->{$pipe}($builder, $request);
        }

        return $this;
    }

    /**
     * Add the given filters or sorts to the refine pipeline.
     *
     * @param  array<int, \Honed\Refine\Refiner>|\Illuminate\Support\Collection<int, \Honed\Refine\Refiner>  $refiners
     * @return $this
     */
    public function using(array|Collection $refiners): static
    {
        if ($refiners instanceof Collection) {
            $refiners = $refiners->all();
        }

        foreach ($refiners as $refiner) {
            match (true) {
                $refiner instanceof Filter => $this->addFilter($refiner),
                $refiner instanceof Sort => $this->addSort($refiner),
                $refiner instanceof Search => $this->addSearch($refiner),
                default => null,
            };
        }

        return $this;
    }
}
