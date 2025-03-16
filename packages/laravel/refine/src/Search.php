<?php

declare(strict_types=1);

namespace Honed\Refine;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 * 
 * @extends Refiner<TModel, TBuilder>
 */
class Search extends Refiner
{
    /**
     * The query boolean to use for the search.
     *
     * @var 'and'|'or'
     */
    protected $boolean = 'and';

    /**
     * Whether the search column is matched.
     *
     * @var bool
     */
    protected $matched = true;

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
     * Get the query boolean.
     * 
     * @return 'and'|'or'
     */
    public function getBoolean()
    {
        return $this->boolean;
    }

    /**
     * Set the search column as matched.
     *
     * @param  bool  $matched
     * @return $this
     */
    public function matched($matched = true)
    {
        $this->matched = $matched;

        return $this;
    }

    /**
     * Get whether the search column is matched.
     *
     * @return bool
     */
    public function isMatched()
    {
        return $this->matched;
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
        return parent::isActive() && $this->isMatched();
    }

    /**
     * {@inheritdoc}
     */
    public function getBindings($value)
    {
        return \array_merge(parent::getBindings($value), [
            'boolean' => $this->getBoolean(),
        ]);
    }

    /**
     * Add the search query scope to the builder.
     *
     * @param  TBuilder  $builder
     * @param  string  $value
     * @param  string  $column
     * @param  string  $boolean
     * @return void
     */
    public function defaultQuery($builder, $value, $column, $boolean = 'and')
    {
        $column = $builder->qualifyColumn($column);
        $sql = \sprintf('LOWER(%s) LIKE ?', $column);
        $binding = ['%'.\mb_strtolower($value, 'UTF8').'%'];

        $builder->whereRaw($sql, $binding, $boolean);
    }
}
