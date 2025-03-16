<?php

declare(strict_types=1);

namespace Honed\Refine;

use Illuminate\Foundation\Http\FormRequest;

class Search extends Refiner
{
    /**
     * The query boolean to use for the search.
     *
     * @var string
     */
    protected $boolean = 'and';

    /**
     * Set the query boolean to use for the search.
     *
     * @param  'and'|'or'  $boolean
     * @return $this
     */
    public function boolean($boolean)
    {
        $this->boolean = $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->type('search');
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return (bool) $this->value;
    }

    /**
     * Search the builder using the request.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  string|null  $search
     * @param  array<int,mixed>|null  $columns
     * @param  string  $boolean
     * @return bool
     */
    public function refine($builder, $search, $columns, $boolean = 'and')
    {
        $shouldBeApplied = empty($columns) ||
            \in_array($this->getParameter(), $columns);

        // The search is active if there are columns to search on, and the
        // parameter is one of them. They are all active by default.
        $this->value($shouldBeApplied);

        
        // We don't do the search if the column is not to be searched on, or if
        // there is no search term.
        if (! $this->isActive() || empty($search)) {
            return false;
        }

        $bindings = [
            'value' => $search,
            'column' => $this->getName(),
            'boolean' => $boolean,
        ];

        $this->defaultQuery($builder, $search, $this->getName(), $boolean);

        return true;
    }

    /**
     * Add the search query scope to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  string  $value
     * @param  string  $column
     * @param  string  $boolean
     * @return void
     */
    public function defaultQuery($builder, $value, $column, $boolean = 'and')
    {
        $column = $builder->qualifyColumn($column);

        $builder->whereRaw(
            sql: "LOWER({$column}) LIKE ?",
            bindings: ['%'.mb_strtolower($value, 'UTF8').'%'],
            boolean: $boolean,
        );
    }
}
