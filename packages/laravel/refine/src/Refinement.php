<?php

declare(strict_types=1);

namespace Honed\Refine;

class Refinement
{
    const COLUMN = ':column';

    const TABLE = ':table';

    const VALUE = ':value';

    /**
     * The statement to use
     * 
     * @var string
     */
    protected $statement;

    /**
     * The column or relation to use
     * 
     * @var string
     */
    protected $columnOrRelation;

    /**
     * The operator to use
     */
    protected $operator;

    /**
     * The value to use
     */
    protected $value;


    /**
     * Create a new refinement
     * 
     * @var string $statement
     * @var string $columnOrRelation
     * @var mixed $operator
     * @var mixed $value
     */
    public function __construct(
        $statement, 
        $columnOrRelation, 
        $operator = '=', 
        $value = null
    ) {
        $this->statement = $statement;
        $this->columnOrRelation = $columnOrRelation;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * Get the builder statement to use.
     * 
     * @return string
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Get the column or relation to use.
     * 
     * @return string
     */
    public function getColumnOrRelation()
    {
        return $this->columnOrRelation;
    }

    /**
     * Determine if an operator was supplied.
     * 
     * @return bool
     */
    public function hasOperator()
    {
        return isset($this->operator);
    }

    /**
     * Determine if a value was supplied.
     * 
     * @return bool
     */
    public function hasValue()
    {
        return \property_exists($this, 'value');
    }
    

    /**
     * Get the operator to use.
     * 
     * @return string|null
     */
    public function getOperator()
    {
        return $this->operator;
    }


    /**
     * Get the value to use.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Refine the builder.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed  $value
     * @return void
     */
    public function refine($builder, $value)
    {
        $statement = $this->getStatement();
        $columnOrRelation = $this->getColumnOrRelation();
        
        if (! $this->hasOperator()) {
            $builder->{$statement}(
                $columnOrRelation,
                $value
            );

            return;
        }

        // The operator may be a value.
        $operator = $this->getOperator();

        $builder->{$statement}(
            $columnOrRelation,
            $operator,
            $value // Use the passed $value instead of $this->value
        );
    }

    protected function replacePlaceholders(mixed $value)
    {
        if ($value === self::COLUMN) {
            return $this->columnOrRelation;
        }

        if ($value === self::VALUE) {
            return $this->value;
        }

        return $value;
    }

    public function rebindClosure($closure)
    {
        dd($closure);
        return fn ($builder) => $closure($builder, $this->value);
    }


        // Validate the operator, which may be a closure

        // using(fn ($builder, $value) => $builder->where('name', $value))
        // using('where', '=', ':value')
        // using('where', ':value')
        // using('has', 'relation')
        // using('whereHas', 'relation', fn ($query) => $query->where('quantity', '>=', 3))
        // using('whereRelation', 'details.quantity', '>=', ':value')


}