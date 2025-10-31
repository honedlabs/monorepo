<?php

namespace Honed\Pivot\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Honed\Pivot\Relations\BelongsToManySoft;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasRelationships
{
    public function belongsToMany()
    {
        return parent::belongsToMany();
    }
    
    /**
     * Instantiate a new BelongsToManySoft relationship.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  string  $table
     * @param  string  $foreignPivotKey
     * @param  string  $relatedPivotKey
     * @param  string  $parentKey
     * @param  string  $relatedKey
     * @param  string  $relationName
     * @return \DDZobov\PivotSoftDeletes\Relations\BelongsToManySoft
     */
    protected function newBelongsToMany(Builder $query, Model $parent, $table, $foreignPivotKey, $relatedPivotKey,
                                        $parentKey, $relatedKey, $relationName = null)
    {
        return new BelongsToManySoft($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }
}