<?php

declare(strict_types=1);

namespace Honed\Refine;

use BadMethodCallException;
use Carbon\Carbon;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasScope;
use Honed\Core\Concerns\InterpretsRequest;
use Honed\Core\Concerns\Validatable;
use Honed\Refine\Concerns\HasDelimiter;
use Honed\Refine\Concerns\HasOptions;

class Filter extends Refiner
{
    use HasDelimiter;
    use HasMeta;
    use HasOptions {
        multiple as protected setMultiple;
    }
    use HasScope;
    use InterpretsRequest;
    use Validatable;

    /**
     * The operator to use for the filter.
     *
     * @var string
     */
    protected $operator = '=';

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->type('filter');
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return $this->hasValue();
    }

    /**
     * Determine if the value is invalid.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function invalidValue($value)
    {
        return ! $this->isActive() || ! $this->validate($value) ||
            ($this->hasOptions() && empty($value));
    }

    /**
     * Get the operator to use for the filter.
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set the operator to use for the filter.
     *
     * @param  string  $operator
     * @return $this
     */
    public function operator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Set the filter to be for boolean values.
     *
     * @return $this
     */
    public function boolean()
    {
        $this->type('boolean');
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
        $this->type('date');
        $this->asDate();

        return $this;
    }

    /**
     * Set the filter to be for date time values.
     *
     * @return $this
     */
    public function dateTime()
    {
        $this->type('datetime');
        $this->asDatetime();

        return $this;
    }

    /**
     * Set the filter to be for float values.
     *
     * @return $this
     */
    public function float()
    {
        $this->type('float');
        $this->asFloat();

        return $this;
    }

    /**
     * Set the filter to be for integer values.
     *
     * @return $this
     */
    public function integer()
    {
        $this->type('integer');
        $this->asInteger();

        return $this;
    }

    /**
     * Set the filter to be for multiple values.
     *
     * @return $this
     */
    public function multiple()
    {
        $this->type('multiple');
        $this->asArray();
        $this->setMultiple();

        return $this;
    }

    /**
     * Set the filter to be for string values.
     *
     * @return $this
     */
    public function string()
    {
        $this->type('string');
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
        $this->type('time');
        $this->asTime();

        return $this;
    }

    /**
     * Filter the builder using the request.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function refine($builder, $request)
    {
        $parameter = $this->getParameter();
        $key = $this->formatScope($parameter);
        $value = $this->interpret($request, $key);

        $this->value($value);

        if ($this->hasOptions()) {
            $value = $this->activateOptions($value);
        }

        if ($this->invalidValue($value)) {
            return false;
        }

        $bindings = [
            'value' => $value,
            'column' => $this->getName(),
            'table' => $builder->getModel()->getTable(),
        ];

        if (! $this->hasQueryClosure()) {
            $this->queryClosure(\Closure::fromCallable([$this, 'defaultQuery']));
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
    public function defaultQuery($builder, $column, $operator, $value)
    {
        $column = $builder->qualifyColumn($column);

        match (true) {
            // If the operator is fuzzy, we do a whereRaw to make it simpler and
            // handle case sensitivity.
            \in_array($operator,
                ['like', 'not like', 'ilike', 'not ilike']
            ) => $builder->whereRaw(
                \sprintf('LOWER(%s) %s ?', $column, \mb_strtoupper(type($operator)->asString(), 'UTF8')),
                ['%'.\mb_strtolower(type($value)->asString(), 'UTF8').'%']
            ),

            // The `whereIn` clause should be used if the filter is set to multiple,
            // or if the filter interprets an array. Generally, both should be true
            // as this case is likely when providing options and allowing multiple.
            $this->isMultiple(),
            $this->interpretsArray() => $builder->whereIn($column, $value),

            // If the filter interprets a date, we use whereDate clause as this
            // allows us to compare using the date strings.
            $this->interpretsDate() => $builder->whereDate($column, $operator, $value), // @phpstan-ignore-line

            // This compares a date time string to the column.
            $this->interpretsTime() => $builder->whereTime($column, $operator, $value), // @phpstan-ignore-line

            // Otherwise, we use a standard where clause - but, allow the operator
            // to be overridden by the developer.
            default => $builder->where($column, $operator, $value),
        };
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $value = $this->getValue();

        if ($value instanceof Carbon) {
            $value = $value->toIso8601String();
        }

        return \array_merge(parent::toArray(), [
            'value' => $value,
            'options' => $this->optionsToArray(),
            'multiple' => $this->isMultiple(),
            'meta' => $this->getMeta(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $parameters)
    {
        if ($method === 'query') {
            /** @var \Closure(mixed...):void|null $query */
            $query = $parameters[0];

            return $this->queryClosure($query);
        }

        return parent::__call($method, $parameters);
    }
}
