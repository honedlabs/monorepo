<?php

declare(strict_types=1);

namespace Honed\Action\Actions\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Workbench\App\Models\Product;

/**
 * @template TParent of \Illuminate\Database\Eloquent\Model
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * 
 * @phpstan-require-implements \Honed\Action\Contracts\FromRelationship
 */
trait Associative
{
    /**
     * Get the relation for the model.
     *
     * @param  TModel  $model
     * @return BelongsTo<TParent, TModel>
     */
    public function getRelationship(Model $model): Relation
    {
        /** @var BelongsTo<TModel, TAttach> */
        return $model->{$this->relationship()}();
    }
}