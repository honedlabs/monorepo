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
     * {@inheritdoc}
     */
    public function isActive()
    {
        return filled($this->getValue());
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestValue($request, $key = null)
    {
        return $this->interpret($request, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function transformParameter($value)
    {
        if (! $this->hasOptions()) {
            return parent::transformParameter($value);
        }
        return $value;
    }
    
    /**
     * {@inheritdoc}
     */
    public function invalidValue($value)
    {
        return ! $this->isActive() || ! $this->validate($value) ||
            ($this->hasOptions() && empty($value));
    }

    /**
     * {@inheritdoc}
     */
    public function getBindings($value)
    {
        return [
            'value' => $value,
            'column' => $this->getName(),
        ];
    }
    

    /**
     * Filter the builder using the request.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $key
     * @return bool
     */
    public function refine($builder, $request, $key = null)
    {
        $value = $this->getRequestParameter($request);

        $value = $this->transformParameter($value);

        if ($this->invalidValue($value)) {
            return false;
        }

        $bindings = $this->getBindings($value);

        if (! $this->hasQueryClosure()) {
            $this->queryClosure(\Closure::fromCallable([$this, 'defaultQuery']));
        }

        $this->modifyQuery($builder, $bindings);

        return true;



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
            static::isFuzzy($operator) =>
                static::queryRaw($builder, $column, $operator, $value),

            $this->isMultiple(),
            $this->interpretsArray() => $builder->whereIn($column, $value),

            $this->interpretsDate() => $builder->whereDate($column, $operator, $value), // @phpstan-ignore-line

            $this->interpretsTime() => $builder->whereTime($column, $operator, $value), // @phpstan-ignore-line

            default => $builder->where($column, $operator, $value),
        };
    }

    /**
     * Determine if the operator is fuzzy.
     *
     * @param  string  $operator
     * @return bool
     */
    protected static function isFuzzy($operator)
    {
        return \in_array($operator, ['like', 'not like', 'ilike', 'not ilike']);
    }

    /**
     * Query the builder using a raw SQL statement.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  string  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @return void
     */
    protected static function queryRaw($builder, $column, $operator, $value)
    {
        $operator = \mb_strtoupper(type($operator)->asString(), 'UTF8');
        $sql = \sprintf('LOWER(%s) %s ?', $column, $operator);
        $binding = ['%'.\mb_strtolower(type($value)->asString(), 'UTF8').'%'];

        $builder->whereRaw($sql, $binding);
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
