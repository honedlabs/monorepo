<?php

declare(strict_types=1);

namespace Honed\Refine;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasQueryClosure;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Primitive;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 * 
 * @extends Primitive<string, mixed>
 * 
 * @method bool refine(mixed ...$parameters)
 * @method void defaultQuery(TBuilder $builder, mixed ...$parameters) Apply the default refiner query to the builder.
 */
abstract class Refiner extends Primitive
{
    use Allowable;
    use HasAlias;
    use HasLabel;
    use HasMeta;
    use HasName;
    use HasType;
    use HasValue;
    /** @use HasQueryClosure<TModel, TBuilder> */
    use HasQueryClosure;    

    /**
     * Create a new refiner instance.
     *
     * @param  string  $name
     * @param  string|null  $label
     * @return static
     */
    public static function make($name, $label = null)
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * Determine if the refiner is currently being applied.
     *
     * @return bool
     */
    abstract public function isActive();

    /**
     * Get the parameter for the refiner.
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->getAlias()
            ?? Str::of($this->getName())
                ->afterLast('.')
                ->value();
    }

    /**
     * Get the refiner as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray()
    {
        return [
            'name' => $this->getParameter(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'active' => $this->isActive(),
            'meta' => $this->getMeta(),
        ];
    }
}
