<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

use BackedEnum;
use Carbon\CarbonInterface;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasScope;
use Honed\Core\Concerns\InterpretsRequest;
use Honed\Core\Concerns\Validatable;
use Honed\Core\Interpret;
use Honed\Refine\Concerns\HasDelimiter;
use Honed\Refine\Filters\Concerns\HasOperator;
use Honed\Refine\Filters\Concerns\HasOptions;
use Honed\Refine\Refiner;
use Honed\Refine\Searches\Concerns\HasSearch;
use ReflectionEnum;

use function array_merge;
use function in_array;
use function is_string;
use function mb_strtoupper;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Refiner<TModel, TBuilder>
 */
class Filter extends Refiner
{
    use HasOptions;
    use InterpretsRequest;
    use Validatable;
    use HasOperator;
    
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
     * Define the type of the filter.
     *
     * @return string
     */
    public function type()
    {
        return 'filter';
    }

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->definition($this);
    }

    /**
     * Define the filter instance.
     *
     * @param  \Honed\Refine\Filters\Filter<TModel, TBuilder>  $filter
     * @return \Honed\Refine\Filters\Filter<TModel, TBuilder>|void
     */
    protected function definition(Filter $filter)
    {
        return $filter;
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
     * Set the filter to be for multiple values.
     *
     * @param  bool  $multiple
     * @return $this
     */
    public function multiple($multiple = true)
    {
        $this->asArray();
        $this->baseMultiple($multiple);

        return $this;
    }

    /**
     * Set the filter to respond only to presence values.
     *
     * @return $this
     */
    public function presence()
    {
        $this->boolean();
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

    /**
     * {@inheritdoc}
     */
    protected function transformParameter($value)
    {
        if (filled($this->getOptions())) {
            return $this->activateOptions($value);
        }

        if ($this->isPresence()) {
            return $value ?: null;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    protected function invalidValue($value)
    {
        return ! $this->validate($value);
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
            $this->isFullText() && is_string($value) => $this->searchRecall(
                $builder,
                $value,
                $column
            ),

            in_array($operator, ['LIKE', 'NOT LIKE', 'ILIKE', 'NOT ILIKE']) &&
                is_string($value) => $this->searchPrecision(
                    $builder,
                    $value,
                    $column,
                    // @phpstan-ignore-next-line
                    operator: $operator
                ),

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
}
