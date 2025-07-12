<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\FromRelationship;
use Honed\Action\Actions\Concerns\Associative;
use Honed\Action\Actions\Concerns\Bulkable;
use Honed\Action\Contracts\FromEloquent;
use Honed\Action\Contracts\FromModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 * @template TAction of \Honed\Action\Actions\DissociateAction<TModel, TParent> = \Honed\Action\Actions\DissociateAction<TModel, TParent>
 */
abstract class BulkDissociateAction extends DatabaseAction implements FromEloquent
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
     */
    public function handle($models): void
    {
        $this->transaction(
            fn () => $this->execute($models)
        );
    }

    /**
     * Execute the action.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     */
    protected function execute($models): void
    {
        $action = $this->getAction();

        $this->run(
            $this->query($models),
            static fn (Model $model) => $action->handle($model)
        );

        $this->after($models);
    }

    /**
     * Perform additional logic after the action has been executed.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     */
    protected function after($models): void
    {
        //
    }
}