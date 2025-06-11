<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

use BackedEnum;
use Carbon\CarbonInterface;
use Closure;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\InterpretsRequest;
use Honed\Core\Concerns\Validatable;
use Honed\Core\Interpret;
use Honed\Refine\Refiner;
use ReflectionEnum;

use function array_merge;
use function in_array;
use function is_string;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Refiner<TModel, TBuilder>
 */
class Filter extends Refiner
{
    use Concerns\HasOperator;
    use Concerns\HasOptions {
        multiple as protected setMultiple;
    }
    use HasValue;
    use InterpretsRequest;
    use Validatable;

    public const BOOLEAN = 'boolean';

    public const DATE = 'date';

    public const DATETIME = 'datetime';

    public const NUMBER = 'number';

    public const SELECT = 'select';

    public const TEXT = 'text';

    public const TIME = 'time';

    public const TRASHED = 'trashed';

    /**
     * Whether the filter only responds to presence values.
     *
     * @var bool
     */
    protected $presence = false;

    /**
     * The default value to use for the filter even if it is not active.
     *
     * @var mixed
     */
    protected $default;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->type('filter');

        $this->definition($this);
    }

    /**
     * Set the filter to be for boolean values.
     *
     * @return $this
     */
    public function boolean()
    {
        $this->type(Filter::BOOLEAN);
        $this->asBoolean();

        return $this;
    }

    /**
     * Set the filter to be for date values.
     *
     * @return $this
     */
    public function date()
    {
        $this->type(Filter::DATE);
        $this->asDate();

        return $this;
    }

    /**
     * Set the filter to be for date time values.
     *
     * @return $this
     */
    public function datetime()
    {
        $this->type(Filter::DATETIME);
        $this->asDatetime();

        return $this;
    }

    /**
     * Set the filter to use options from an enum.
     *
     * @param  class-string<BackedEnum>  $enum
     * @param  bool  $multiple
     * @return $this
     */
    public function enum($enum, $multiple = false)
    {
        $this->options($enum);

        /** @var 'int'|'string'|null $backing */
        $backing = (new ReflectionEnum($enum))
            ->getBackingType()
            ?->getName();

        $this->subtype($backing);
        $this->multiple($multiple);

        return $this;
    }

/**
     * Set the filter to be for float values.
     *
     * @return $this
     */
    public function float()
    {
        $this->type(Filter::NUMBER);
        $this->asFloat();

        return $this;
    }

    /**
     * Set the filter to be for integer values.
     *
     * @return $this
     */
    public function int()
    {
        $this->type(Filter::NUMBER);
        $this->asInt();

        return $this;
    }

    /**
     * Set the filter to be for multiple values.
     *
     * @param  bool  $multiple
     * @return $this
     */
    public function multiple($multiple = true)
    {
        $this->type(Filter::SELECT);
        $this->asArray();
        $this->setMultiple($multiple);

        return $this;
    }

    /**
     * Set the filter to be for text values.
     *
     * @return $this
     */
    public function text()
    {
        $this->type(Filter::TEXT);
        $this->asString();

        return $this;
    }

    /**
     * Set the filter to be for time values.
     *
     * @return $this
     */
    public function time()
    {
        $this->type(Filter::TIME);
        $this->asTime();

        return $this;
    }

    /**
     * Set the filter to respond only to presence values.
     *
     * @return $this
     */
    public function presence()
    {
        $this->asBoolean();
        $this->presence = true;

        return $this;
    }

    /**
     * Determine if the filter only responds to presence values.
     *
     * @return bool
     */
    public function isPresence()
    {
        return $this->presence;
    }

    /**
     * Set a default value to use for the filter if the filter is not active.
     *
     * @param  mixed  $default
     * @return $this
     */
    public function default($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get the default value to use for the filter if the filter is not active.
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Get the query value from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @param  string  $delimiter
     * @return mixed
     */
    public function getRequestValue($request, $key, $delimiter = ',')
    {
        $value = (new Interpret())
            ->interpret($request, $key, $delimiter);

        return $value ?? $this->getDefault();
    }

    public function handle($builder, $value)
    {
        $this->value = $this->transformParameter($value);

        $this->active(filled($this->value));

        if ($this->isInactive() || ! $this->validate($this->value)) {
            return false;
        }

        $bindings = $this->getBindings($this->value, $builder);

        if (! $this->hasQuery()) {
            $this->query(Closure::fromCallable([$this, 'apply']));
        }

        $this->modifyQuery($builder, $bindings);

        return true;
    }

    /**
     * Apply the default filter query to the builder.
     *
     * @param  TBuilder  $builder
     * @param  string  $column
     * @param  string|null  $operator
     * @param  mixed  $value
     * @return void
     */
    public function apply($builder, $column, $operator, $value)
    {
        match (true) {
            // in_array($operator, ['LIKE', 'NOT LIKE', 'ILIKE', 'NOT ILIKE']) &&
            //     is_string($value) => $this->searchPrecision(
            //         $builder,
            //         $value,
            //         $column,
            //         operator: $operator
            //     ),

            $this->isMultiple() ||
                $this->interpretsArray() => $builder->whereIn($column, $value),

            $this->interpretsDate() =>
                // @phpstan-ignore-next-line
                $builder->whereDate($column, $operator, $value),

            $this->interpretsTime() =>
                // @phpstan-ignore-next-line
                $builder->whereTime($column, $operator, $value),

            default => $builder->where($column, $operator, $value),
        };
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($named = [], $typed = [])
    {
        $value = $this->getValue();

        if ($value instanceof CarbonInterface) {
            $value = $value->toIso8601String();
        }

        return array_merge(parent::toArray(), [
            'value' => $value,
            'options' => $this->optionsToArray(),
        ]);
    }

    /**
     * Define the filter instance.
     *
     * @param  $this  $filter
     * @return $this|void
     */
    protected function definition(self $filter)
    {
        return $filter;
    }

    /**
     * {@inheritdoc}
     */
    protected function transformParameter($value)
    {
        return match (true) {
            filled($this->getOptions()) => $this->activateOptions($value),
            $this->isPresence() => $value ?: null,
            default => $value,
        };
    }

    /**
     * {@inheritdoc}
     */
    protected function getBindings($value, $builder)
    {
        return array_merge(parent::getBindings($value, $builder), [
            'operator' => $this->getOperator(),
        ]);
    }
}
