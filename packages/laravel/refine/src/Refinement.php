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

    public function refine($builder, $value)
    {
        $builder->{$this->statement}($this->columnOrRelation, $this->operator, $this->value);

    }


        // Validate the operator, which may be a closure

        // using(fn ($builder, $value) => $builder->where('name', $value))
        // using('where', '=', ':value')
        // using('where', ':value')
        // using('has', 'relation')
        // using('whereHas', 'relation', fn ($query) => $query->where('quantity', '>=', 3))
        // using('whereRelation', 'details.quantity', '>=', ':value')
        // using('whereHasMorph', 'relation', 'type', fn ($query, $value) => $query->where('quantity', '>=', $value)) -> dont support


}