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
 * @template TAction of \Honed\Action\Actions\AttachAction = \Honed\Action\Actions\AttachAction
 * 
 * @extends \Honed\Action\Actions\BulkAction<TModel, TAction>
 */
abstract class BulkAttachAction extends BulkAction
{
    /**
     * Attach many models to many models.
     * 
     * @template T of int|string|TModel|null
     * @template U of int|string|TParent|null
     * 
     * @param T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     * @param U|array<int, U>|\Illuminate\Support\Collection<int, U> $ids
     */
    public function handle($models, $ids, $attributes = []): void
    {
        $this->transaction(
            fn () => $this->execute($models, $ids, $attributes)
        );
    }

    /**
     * Execute the action.
     * 
     * @template T of int|string|TModel|null
     * @template U of int|string|TParent|null
     * 
     * @param T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     * @param U|array<int, U>|\Illuminate\Support\Collection<int, U> $ids
     */
    protected function execute($models, $ids, $attributes): void
    {
        $action = $this->getAction();

        $this->run(
            $this->query($models),
            static fn (Model $model) => $action->handle($model, $ids, $attributes)
        );

        $this->after($models, $ids, $attributes);
    }

    /**
     * Perform additional logic after the action has been executed.
     * 
     * @template T of int|string|TModel|null
     * @template U of int|string|TParent|null
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     * @param  U|array<int, U>|\Illuminate\Support\Collection<int, U> $ids
     * @param  array<string, mixed> $attributes
     */
    protected function after($models, $ids, $attributes): void
    {
        //
    }
}