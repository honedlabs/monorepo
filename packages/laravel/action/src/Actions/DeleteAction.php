<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Illuminate\Support\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TType of TModel|\Illuminate\Support\Collection<int, TModel>|\Illuminate\Database\Eloquent\Builder<TModel>|\Illuminate\Database\Eloquent\Relations\Relation<*, *, *> = TModel
 */
class DeleteAction extends DatabaseAction
{
    /**
     * Destroy the model(s).
     *
     * @param  TType  $model
     * @return TType
     */
    public function handle($model)
    {
        $this->transaction(
            fn () => $this->execute($model)
        );

        return $model;
    }

    /**
     * Execute the action.
     *
     * @param  TType  $model
     */
    protected function execute($model): void
    {
        match (true) {
            $model instanceof Collection => $model->each->delete(),
            default => $model->delete()
        };

        $this->after($model);
    }

    /**
     * Perform additional logic after the action has been executed.
     *
     * @param  TType  $model
     */
    protected function after($model): void
    {
        //
    }
}
