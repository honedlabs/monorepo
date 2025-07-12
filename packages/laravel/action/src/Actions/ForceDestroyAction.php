<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Illuminate\Database\Eloquent\Model;
use Workbench\App\Models\Product;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class ForceDestroyAction extends DatabaseAction
{
    /**
     * Force destroy the model.
     *
     * @param  TModel  $model
     * @return TModel
     */
    public function handle($model)
    {
        $this->call(
            fn () => $this->perform($model)
        );

        return $model;
    }

    /**
     * Destroy the model(s).
     *
     * @param  TModel  $model
     */
    protected function perform($model): void
    {
        $model->forceDelete();

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
