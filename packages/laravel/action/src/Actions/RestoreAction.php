<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Workbench\App\Models\Product;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class RestoreAction extends DatabaseAction
{
    /**
     * Restore the model(s).
     *
     * @param  TModel  $model
     * @return TModel
     */
    public function handle($model)
    {
        return $this->transaction(
            fn () => $this->execute($model)
        );
    }

    /**
     * Execute the action.
     *
     * @param  TModel  $model
     * @return TModel
     */
    protected function execute($model)
    {
        $model = $model->restore(); // @phpstan-ignore method.notFound

        $this->after($model);

        return $model;
    }

    /**
     * Perform additional logic after the model(s) have been restored.
     *
     * @param  TModel  $model
     */
    protected function after($model): void
    {
        //
    }
}
