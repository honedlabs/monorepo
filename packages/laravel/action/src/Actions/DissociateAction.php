<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\Associative;
use Honed\Action\Contracts\FromRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 */
abstract class DissociateAction extends DatabaseAction implements FromRelationship
{
    /**
     * @use \Honed\Action\Actions\Concerns\Associative<TParent, TModel>
     */
    use Associative;

    /**
     * Dissociate a model from the parent model.
     *
     * @param  TModel  $model
     * @return TModel
     */
    public function handle(Model $model): Model
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
    protected function execute(Model $model): Model
    {
        $this->getRelationship($model)->dissociate();

        $model->save();

        $this->after($model);

        return $model;
    }

    /**
     * Perform additional logic after the action has been executed.
     *
     * @param  TModel  $model
     */
    protected function after(Model $model): void
    {
        //
    }
}
