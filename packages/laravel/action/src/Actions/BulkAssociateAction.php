<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\Relatable;
use Honed\Action\Actions\Concerns\Associative;
use Honed\Action\Actions\Concerns\Bulkable;
use Honed\Action\Contracts\RequiresModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 * @template TAction of \Honed\Action\Actions\AssociateAction = \Honed\Action\Actions\AssociateAction
 */
abstract class BulkAssociateAction extends DatabaseAction implements RequiresModel
{
    /**
     * @use \Honed\Action\Actions\Concerns\Bulkable<TModel, TAction>
     */
    use Bulkable;

    /**
     * Associate many models to one parent.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     * @param int|string|TParent|null $parent
     */
    public function handle($models, $parent): void
    {
        $this->transaction(
            fn () => $this->execute($models, $parent)
        );
    }

    /**
     * Perform the database action.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     * @param int|string|TParent|null $parent
     */
    protected function execute($models, $parent): void
    {
        $action = $this->getAction();

        $this->run(
            $this->query($models),
            static fn (Model $model) => $action->handle($model, $parent)
        );

        $this->after($models, $parent);
    }

    /**
     * Perform additional logic after the model has been associated.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     * @param  int|string|TParent|null  $parent
     */
    protected function after($models, $parent): void
    {
        //
    }
}