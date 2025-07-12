<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Illuminate\Support\Arr;
use Honed\Action\Contracts\FromRelationship;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Actions\Concerns\Attachable;
use Honed\Action\Actions\Concerns\InteractsWithModels;
use Honed\Action\Actions\Concerns\InteractsWithFormData;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 * 
 * @implements \Honed\Action\Contracts\FromRelationship<TModel, BelongsTo<TParent, TModel>>
 * 
 * @internal
 */
abstract class BelongsToAction extends DatabaseAction implements FromRelationship
{
        /**
     * Get the relation for the model.
     *
     * @param  TModel  $model
     * @return BelongsTo<TParent, TModel>
     */
    public function getRelationship(Model $model): Relation
    {
        /** @var BelongsTo<TParent, TModel> */
        return $model->{$this->relationship()}();
    }
}
