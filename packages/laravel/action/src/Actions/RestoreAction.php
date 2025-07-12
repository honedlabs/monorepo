<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class RestoreAction extends DatabaseAction
{
    /**
     * Restore the model(s).
     *
     * @param  TModel|\Illuminate\Database\Eloquent\Builder<TModel>  $model
     * @return TModel|\Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function handle($model)
    {
        return $this->call(
            fn () => $this->perform($model)
        );
    }

    /**
     * Restore the model(s).
     *
     * @param  TModel|\Illuminate\Database\Eloquent\Builder<TModel>  $model
     * @return TModel|\Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    protected function perform($model)
    {
        $models = $model->restore(); // @phpstan-ignore method.notFound

        $this->after($models);

        return $models;
    }

    /**
     * Perform additional logic after the model(s) have been restored.
     *
     * @param  TModel|\Illuminate\Database\Eloquent\Collection<int, TModel>  $models
     */
    protected function after($models): void
    {
        //
    }
}
