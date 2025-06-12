<?php

declare(strict_types=1);

namespace Honed\Action\Presets;

use Honed\Action\Contracts\Actionable;
use Illuminate\Support\Arr;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TArg of 'model' | 'models' | 'query' = 'model'
 */
abstract class DestroyAction implements Actionable
{
    use Concerns\CanBeTransaction;

    /**
     * Destroy the model(s).
     * 
     * @param TArg is 'model' ? TModel : TArg is 'models' ? iterable<int, TModel> : \Illuminate\Database\Eloquent\Builder<TModel> $model
     * @return void
     */
    public function handle($model)
    {
        $this->transact(
            fn () => $this->destroy($model)
        );

        $this->after($model);
    }

    /**
     * Destroy the model(s).
     * 
     * @param TArg is 'model' ? TModel : TArg is 'models' ? iterable<int, TModel> : \Illuminate\Database\Eloquent\Builder<TModel> $model
     * @return void
     */
    protected function destroy($model)
    {
        if (Arr::accessible($model)) {
            foreach ($model as $item) {
                $item->delete();
            }
        } else {
            $model->delete();
        }
    }

    /**
     * Perform additional logic after the model has been deleted.
     * 
     * @param TArg is 'model' ? TModel : TArg is 'models' ? iterable<int, TModel> : \Illuminate\Database\Eloquent\Builder<TModel> $model
     * @return void
     */
    protected function after($model)
    {
        //
    }
}
