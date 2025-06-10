<?php

declare(strict_types=1);

namespace Honed\Refine\Searches;

use function is_null;
use function array_merge;
use Honed\Refine\Refiner;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Refiner<TModel, TBuilder>
 */
class Search extends Refiner
{
    /**
     * @use Concerns\HasSearch<TModel, TBuilder>
     */
    use Concerns\HasSearch;

    /**
     * The query boolean to use for the search.
     *
     * @var 'and'|'or'
     */
    protected $boolean = 'and';

    /**
     * Define the type of the search.
     *
     * @return string
     */
    public function type()
    {
        return 'search';
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
     * Define the search instance.
     *
     * @param  \Honed\Refine\Searches\Search<TModel, TBuilder>  $search
     * @return \Honed\Refine\Searches\Search<TModel, TBuilder>|void
     */
    protected function definition(Search $search)
    {
        return $search;
    }

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
     * {@inheritdoc}
     */
    public function isActive()
    {
        [$active, $_] = $this->getValue();

        return $active;
    }

    // /**
    //  * {@inheritdoc}
    //  *
    //  * @param  array{bool, string|null}  $value
    //  */
    // public function getRequestValue($value)
    // {
    //     return parent::getRequestValue($value);
    // }

    /**
     * {@inheritdoc}
     *
     * @return array{bool, string|null}
     */
    public function getValue()
    {
        /** @var array{bool, string|null} */
        return parent::getValue();
    }

    /**
     * {@inheritdoc}
     *
     * @param  array{bool, string|null}  $value
     */
    public function invalidValue($value)
    {
        [$_, $term] = $value;

        return is_null($term);
    }

    /**
     * {@inheritdoc}
     *
     * @param  array{bool, string|null}  $value
     */
    public function getBindings($value, $builder)
    {
        [$_, $term] = $value;

        return array_merge(parent::getBindings($term, $builder), [
            'boolean' => $this->getBoolean(),
            'term' => $term,
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
    public function apply($builder, $value, $column, $boolean = 'and')
    {
        if ($this->isFullText()) {
            $this->searchRecall($builder, $value, $column, $boolean);

            return;
        }

        $this->searchPrecision($builder, $value, $column, $boolean);
    }
}
