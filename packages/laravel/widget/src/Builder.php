<?php

declare(strict_types=1);

namespace Honed\Widget;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 *
 * @extends \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @mixin \Honed\Widget\QueryBuilder
 *
 * @method $this scope(mixed $scope) Add a `where` clause to the query for the scope.
 * @method $this widget(string $widget) Add a `where` clause to the query for the widget.
 */
class Builder extends EloquentBuilder
{
    /**
     * Create a new Eloquent query builder instance.
     */
    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);
    }
}
