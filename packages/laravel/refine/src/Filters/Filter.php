<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

use Closure;
use Honed\Refine\Refiner;
use Illuminate\Http\Request;
use Honed\Core\Concerns\HasScope;
use Illuminate\Support\Collection;
use Honed\Core\Concerns\Validatable;
use Honed\Refine\Filters\Concerns\HasOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Honed\Refine\Concerns\InterpretsRequest;
class Filter extends Refiner
{
    use HasScope;
    use Validatable;
    use HasOptions;
    use InterpretsRequest;

    const Is = '=';

    const Not = '!=';

    const GreaterThan = '>=';

    const LessThan = '<=';

    /**
     * The options for the filter.
     *
     * @var array<int,\Honed\Refine\Filters\Concerns\Option>|null
     */
    protected $options;

    /**
     * Whether to restrict values to only the options provided.
     * 
     * @var bool|null
     */
    protected $strict;

    /**
     * The value type to interpret the query parameter as.
     * 
     * @var string|null
     */
    protected $as;

    /**
     * Whether to accept multiple values.
     *
     * @var bool
     */
    protected $multiple = false;

    /**
     * The statement, or callback, to use to resolve the filter.
     *
     * @var string|\Closure
     */
    protected $using = 'where';

    /**
     * 
     */
    protected $columnOrRelation = null;

    /**
     * The operator to use.
     *
     * @var string
     */
    protected $operator = '=';

    /**
     * Set the options for the filter.
     *
     * @param  class-string<\BackedEnum>|array<int,mixed>|Collection<int,mixed>  $options
     * @return $this
     */
    public function options($options)
    {
        if ($options instanceof Collection) {
            $options = $options->all();
        }

    }

    // public function optionsEnumerated()

    /**
     * Register a closure to use as the filter statement.
     * 
     * @param  \Closure  $using
     * @return $this
     */
    public function using(\Closure $using)
    {
        $this->using = $using;

        return $this;
    }

    /**
     * Register a clause to use as the filter statement.
     * 
     * @param  string|\Closure  $using
     * @param  mixed  $column
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return $this
     */
    public function statement(string|\Closure $statement, mixed $columnOrRelation = null, mixed $operator = '=', mixed $value = null)
    {
        if ($statement instanceof Closure) {
            return $this->using($statement);
        }

        $this->using = $using;
        $this->columnOrRelation = $columnOrRelation;

        [$value, $operator] = $this->prepareValueAndOperator(
            $value, $operator, func_num_args() === 3
        );

        // Validate the operator, which may be a closure

        // using(fn ($builder, $value) => $builder->where('name', $value))
        // using('where', '=', ':value')
        // using('where', ':value')
        // using('has', 'relation')
        // using('whereHas', 'relation', fn ($query) => $query->where('quantity', '>=', 3))
        // using('whereRelation', 'details.quantity', '>=', ':value')
        // using('whereHasMorph', 'relation', 'type', fn ($query, $value) => $query->where('quantity', '>=', $value)) -> dont support
    }

    /**
     * Prepare the value and operator for a where clause.
     *
     * @param  string  $value
     * @param  string  $operator
     * @param  bool  $useDefault
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function prepareValueAndOperator($value, $operator, $useDefault = false)
    {
        if ($useDefault) {
            return [$operator, '='];
        } elseif ($this->invalidOperatorAndValue($operator, $value)) {
            throw new \InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    /**
     * Interpret the request parameter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $as
     * @return mixed
     */
    public function interpret($request, $as)
    {
        return match ($this->as) {
            'boolean' => $request->safeBoolean($as),
            'integer' => $request->safeInt($as),
            'float' => $request->safeFloat($as),
            'string' => $request->safeString($as),
            default => $request->safe($as),
        };
    }

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
    public function getUniqueKey()
    {
        return \sprintf(
            '%s.%s.%s',
            $this->getName(),
            $this->getOperator(),
            $this->getMode(),
        );
    }

    /**
     * Determine if the filter is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->hasValue();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return \array_merge(parent::toArray(), [
            'value' => $this->getValue(),
        ]);
    }

    /**
     * Filter the builder using the request.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function apply($builder, $request)
    {
        $value = $this->interpret($request, $this->as);

        $this->value($value);

        if (! $this->isActive() || ! $this->validate($value)) {
            return false;
        }

        $this->handle($builder, $value);

        return true;
    }

    public function applyBinding($builder, $value)
    {
    }

    /**
     * Add the filter query scope to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed  $value
     * @return void
     */
    public function handle($builder, $value)
    {
        if (! ($this->hasQueryCallback() && ! $this->hasStatement())) {
            $this->applyBinding($builder, $value);
            return;
        }

        $operator = match (\mb_strtolower($operator = $this->getOperator())) {
            '=', 'like' => 'LIKE',
            '!=', 'not like' => 'NOT LIKE',
            default => throw new \InvalidArgumentException("Invalid operator [{$operator}] provided for [{$property}] filter.")
        };

        $sql = match ($this->getMode()) {
            self::StartsWith => "{$column} {$operator} ?",
            self::EndsWith => "{$column} {$operator} ?",
            default => "LOWER({$column}) {$operator} ?",
        };

        $bindings = match ($this->getMode()) {
            self::StartsWith => ["{$value}%"], // @phpstan-ignore-line
            self::EndsWith => ["%{$value}"], // @phpstan-ignore-line
            default => ['%'.mb_strtolower((string) $value, 'UTF8').'%'], // @phpstan-ignore-line
        };

        $builder->whereRaw(
            sql: $sql,
            bindings: $bindings,
            boolean: 'and'
        );
    }

    /**
     * Retrieve the filter value from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|int|float|bool|null
     */
    public function getRefiningValue($request)
    {
        $key = $this->formatScope($this->getParameter());

        return $request->safe($key);
    }

    /**
     * Set the operator for the filter.
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
     * Set the operator to not.
     *
     * @return $this
     */
    public function not()
    {
        return $this->operator(self::Not);
    }

    /**
     * Set the operator to greater than.
     *
     * @return $this
     */
    public function gt()
    {
        return $this->operator(self::GreaterThan);
    }

    /**
     * Set the operator to less than or equal to.
     *
     * @return $this
     */
    public function lt()
    {
        return $this->operator(self::LessThan);
    }

    /**
     * Get the operator for the filter.
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
