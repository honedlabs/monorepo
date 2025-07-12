<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\Relatable;
use Honed\Action\Actions\Concerns\Associative;
use Honed\Action\Actions\Concerns\Bulkable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 * @template TAction of \Honed\Action\Actions\AssociateAction
 */
abstract class BulkAssociateAction extends DatabaseAction implements Relatable
{
    /**
     * @use \Honed\Action\Actions\Concerns\Bulkable<TModel, TAction>
     */
    use Bulkable;

    /**
     * Get the associate action to use.
     * 
     * @return class-string<TAction>
     */
    abstract public function action(): string;

    /**
     * Associate many models to one parent.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param T|iterable<int, T> $models
     * @param int|string|TParent|null $parent
     */
    public function handle($models, $parent): void
    {
        $this->callTransaction(
            fn () => $this->perform($models, $parent)
        );
    }

    /**
     * Perform the database action.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param T|iterable<int, T> $models
     * @param int|string|TParent|null $parent
     */
    protected function perform($models, $parent): void
    {
        $action = $this->getAction();

        $this->run(
            $this->getQuery($models),
            static fn (Model $model) => $action->handle($model, $parent)
        );

        $this->after($models, $parent);
    }

    /**
     * Get the relation for the model.
     *
     * @param  TModel  $model
     * @return BelongsToMany<TParent, TModel>
     */
    protected function getRelationship(Model $model): Relation
    {
        /** @var BelongsTo<TParent, TModel> */
        return $model->{$this->relationship()}();
    }

    /**
     * Perform additional logic after the model has been associated.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param  T|iterable<int, T> $models
     * @param  int|string|TParent|null  $parent
     */
    protected function after($models, $parent): void
    {
        //
    }
}