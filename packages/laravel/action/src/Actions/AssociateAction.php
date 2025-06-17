<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 */
abstract class AssociateAction implements Action
{
    use Concerns\CanBeTransaction;

    /**
     * Get the relation name, must be a belongs to relationship.
     *
     * @return string
     */
    abstract protected function relationship(): string;

    /**
     * Associate a model to the parent model.
     *
     * @param  TModel  $model
     * @param  int|string|TParent  $parent
     * @return void
     */
    public function handle(Model $model, int|string|Model $parent): Model
    {
        $this->transact(
            fn () => $this->associate($model, $parent)
        );

        return $model;
    }

    /**
     * Get the relation for the model.
     *
     * @param  TModel  $model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TParent, TModel>
     */
    protected function getRelation(Model $model): BelongsTo
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo<TParent, TModel> */
        return $model->{$this->relationship()}();
    }

    /**
     * Store the parent in the database.
     *
     * @param  TModel  $model
     * @param  int|string|TParent  $parent
     * @return void
     */
    protected function associate(Model $model, int|string|Model $parent): void
    {
        $this->getRelation($model)->associate($parent);

        $this->after($model, $parent);
    }

    /**
     * Perform additional logic after the model has been attached.
     *
     * @param  TModel  $model
     * @param  int|string|TParent  $parent
     * @return void
     */
    protected function after(Model $model, int|string|Model $parent): void
    {
        //
    }
}
