<?php

declare(strict_types=1);

namespace Honed\Refine;

use Closure;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasQuery;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Primitive;
use Honed\Refine\Concerns\CanBeHidden;
use Honed\Refine\Concerns\HasQualifier;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @method void apply(TBuilder $builder, mixed ...$parameters) Apply the refiner query to apply to the builder.
 */
abstract class Refiner extends Primitive
{
    use CanBeHidden;
    use Allowable;
    use HasAlias;
    use HasLabel;
    use HasMeta;
    use HasName;
    use HasQualifier;
    use IsActive;

    /** @use HasQuery<TModel, TBuilder> */
    use HasQuery;
    use HasValue;

    /**
     * Define the type of the refiner.
     * 
     * @return string
     */
    abstract public function type();

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
     * Get the parameter for the refiner.
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->getAlias() ?? $this->guessParameter();
    }

    /**
     * Guess the parameter for the refiner.
     *
     * @return string
     */
    protected function guessParameter()
    {
        return Str::of($this->getName())
            ->afterLast('.')
            ->value();
    }

    /**
     * Transform the value for the refiner from the request.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function transformParameter($value)
    {
        return $value;
    }

    /**
     * Determine if the value is invalid.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function invalidValue($value)
    {
        return false;
    }

    /**
     * Get the bindings for the refiner closure.
     *
     * @param  mixed  $value
     * @param  TBuilder  $builder
     * @return array<string,mixed>
     */
    protected function getBindings($value, $builder)
    {
        return [
            'value' => $value,
            'name' => $this->getName(),
            'column' => $this->qualifyColumn($this->getName(), $builder),
        ];
    }

    /**
     * Refine the builder using the request.
     *
     * @param  TBuilder  $builder
     * @param  mixed  $value
     * @return bool
     */
    public function refine($builder, $value)
    {
        $value = $this->transformParameter($value);

        $this->value($value);

        if (! $this->isActive() || $this->invalidValue($value)) {
            return false;
        }

        $bindings = $this->getBindings($value, $builder);

        if (! $this->hasQuery()) {
            $this->query(Closure::fromCallable([$this, 'apply']));
        }

        $this->modifyQuery($builder, $bindings);

        return true;
    }

    /**
     * Get the refiner as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray($named = [], $typed = [])
    {
        return [
            'name' => $this->getParameter(),
            'label' => $this->getLabel(),
            'type' => $this->type(),
            'active' => $this->isActive(),
            'meta' => $this->getMeta(),
        ];
    }
}
