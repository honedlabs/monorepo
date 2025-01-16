<?php

namespace Honed\Refining;

use Honed\Core\Concerns\HasScope;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Honed\Refining\Contracts\Refines;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Refine extends Primitive
{
    use ForwardsCalls;
    use HasScope;
    use Concerns\HasBuilderInstance;
    use Concerns\HasFilters;
    use Concerns\HasSorts;
    use Concerns\HasRequest;

    public function __construct(Request $request)
    {
        $this->request($request);
    }

    public function __call($name, $arguments)
    {
        return $this->forwardDecoratedCallTo($this->getBuilder(), $name, $arguments);
    }

    public static function make(Model|string|Builder $model)
    {
        return static::query($model);
    }

    /**
     * Refines the given model.
     */
    public static function model(Model|string $model): static
    {
        return static::query($model);
    }

    /**
     * Refines the given query.
     */
    public static function query(Model|string|Builder $query): static
    {
        if ($query instanceof Model) {
            $query = $query::query();
        }

        if (\is_string($query) && class_exists($query) && is_subclass_of($query, Model::class)) {
            $query = $query::query();
        }

        if (!$query instanceof Builder) {
            throw new \InvalidArgumentException('Expected a model class name or a query instance.');
        }

        return resolve(static::class)->builder($query);
    }

    public function toArray()
    {
        return [
            'sorts' => $this->getSorts()->toArray(),
            'filters' => $this->getFilters()->toArray(),
            'scope' => $this->getScope(),
        ];
    }

    
}
