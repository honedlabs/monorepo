<?php

declare(strict_types=1);

namespace Honed\Refining;

use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Honed\Refining\Sorts\Sort;
use Honed\Core\Concerns\HasScope;
use Honed\Refining\Filters\Filter;
use Honed\Refining\Contracts\Refines;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
 * @extends Primitive<string, mixed>
 */
class Refine extends Primitive
{
    use ForwardsCalls;
    use HasScope;
    use Concerns\HasBuilderInstance;
    use Concerns\HasFilters;
    use Concerns\HasSorts;
    use Concerns\HasRequest;
    use Concerns\HasSearch;

    protected bool $refined = false;

    // protected bool $scout = false;

    public function __construct(Request $request)
    {
        $this->request($request);
    }

    /**
     * @param string $name
     * @param array<int, mixed> $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if ($name === 'sorts') {
            /** @var array<int, \Honed\Refining\Sorts\Sort> $arguments */
            return $this->addSorts($arguments);
        }

        if ($name === 'filters') {
            /** @var array<int, \Honed\Refining\Filters\Filter> $arguments */
            return $this->addFilters($arguments);
        }

        // Delay the refine call
        $this->refine();

        return $this->forwardDecoratedCallTo($this->getBuilder(), $name, $arguments);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>|\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $model
     */
    public static function make(Model|string|Builder $model): static
    {
        return static::query($model);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model> $model
     */
    public static function model(Model|string $model): static
    {
        return static::query($model);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>|\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $query
     */
    public static function query(Model|string|Builder $query): static
    {
        if ($query instanceof Model) {
            $query = $query::query();
        }

        if (\is_string($query) && \class_exists($query)) {
            $query = $query::query();
        }

        if (!$query instanceof Builder) {
            throw new \InvalidArgumentException('Expected a model class name or a query instance.');
        }

        return resolve(static::class)->builder($query);
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray()
    {
        return [
            'sorts' => $this->getSorts(),
            'filters' => $this->getFilters(),
            'searches' => $this->getSearches(),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function refinements(): array
    {
        return $this->toArray();
    }

    /**
     * @return $this
     */
    public function refine(): static
    {
        if ($this->refined) {
            return $this;
        }

        // $this->search($this->getBuilder(), $this->getRequest()); // Apply search first to determine scout usage
        $this->sort($this->getBuilder(), $this->getRequest());
        $this->filter($this->getBuilder(), $this->getRequest());

        $this->refined = true;

        return $this;
    }

    /**
     * Add the given filters or sorts to the refine pipeline.
     * 
     * @param iterable<\Honed\Refining\Refiner> $refiners
     * @return $this
     */
    public function with(iterable $refiners): static
    {
        foreach ($refiners as $refiner) {
            match (true) {
                $refiner instanceof Filter => $this->addFilter($refiner),
                $refiner instanceof Sort => $this->addSort($refiner),
                default => null,
            };
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function for(Request $request): static
    {
        return $this->request($request);
    }
}
