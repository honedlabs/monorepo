<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\Associative;
use Honed\Action\Contracts\Relatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 * 
 * @implements \Honed\Action\Contracts\Relatable<TModel, BelongsTo<TParent, TModel>>
 */
abstract class AssociateAction extends DatabaseAction implements Relatable
{
    /**
     * @use \Honed\Action\Actions\Concerns\Associative<TParent, TModel>
     */
    use Associative;

    /**
     * Associate a model to the parent model.
     *
     * @param  TModel  $model
     * @param  int|string|TParent|null  $parent
     * @return TModel
     */
    public function handle(Model $model, $parent): Model
    {
        return $this->transaction(
            fn () => $this->execute($model, $parent)
        );
    }

    /**
     * Store the parent in the database.
     *
     * @param  TModel  $model
     * @param  int|string|TParent|null  $parent
     * @return TModel
     */
    protected function execute(Model $model, $parent): Model
    {
        $model = $this->getRelationship($model)->associate($parent);

        $model->save();

        $this->after($model, $parent);

        return $model;
    }

    /**
     * Perform additional logic after the model has been attached.
     *
     * @param  TModel  $model
     * @param  int|string|TParent|null  $parent
     */
    protected function after(Model $model, $parent): void
    {
        //
    }
}
