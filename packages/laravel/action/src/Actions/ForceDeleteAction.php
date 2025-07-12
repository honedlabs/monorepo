<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Workbench\App\Models\Product;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TType of TModel|\Illuminate\Support\Collection<int, TModel>|\Illuminate\Database\Eloquent\Builder<TModel>|\Illuminate\Database\Eloquent\Relations\Relation<*, *, *> = TModel
 */
class ForceDeleteAction extends DatabaseAction
{
    /**
     * Force destroy the model.
     *
     * @param  TType  $model
     * @return TType
     */
    public function handle($model)
    {
        $this->transaction(
            fn () => $this->perform($model)
        );

        return $model;
    }

    /**
     * Destroy the model(s).
     *
     * @param  TType  $model
     */
    protected function perform($model): void
    {
        match (true) {
            $model instanceof Collection => $model->each->forceDelete(),
            default => $model->forceDelete()
        };

        $this->after($model);
    }

    /**
     * Perform additional logic after the model has been deleted.
     *
     * @param  TModel  $model
     */
    protected function after($model): void
    {
        //
    }
}
