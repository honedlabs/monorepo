<?php

declare(strict_types=1);

namespace Honed\Action\Presets;

use Honed\Action\Contracts\Actionable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 */
abstract class DissociateAction implements Actionable
{
    use Concerns\CanBeTransaction;

    /**
     * Get the relation name, must be a belongs-to-many relationship.
     * 
     * @return string
     */
    abstract protected function relation();

    /**
     * Get the relation for the model.
     * 
     * @param TModel $model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TParent, TModel>
     */
    protected function getRelation($model)
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo<TParent, TModel> */
        return $model->{$this->relation()}();
    }

    /**
     * Dissociate a model from the parent model.
     * 
     * @param TModel $model
     * 
     * @return void
     */
    public function handle($model)
    {
        $this->transact(
            fn () => $this->dissociate($model)
        );
    }
    /**
     * Dissociate the parent from the model.
     * 
     * @param TModel $model
     * 
     * @return void
     */
    protected function dissociate($model)
    {
        $this->getRelation($model)->dissociate();

        $model->save();

        $this->after($model);
    }

    /**
     * Perform any actions after the model has been attached.
     * 
     * @param TModel $model
     * 
     * @return void
     */
    protected function after($model)
    {
        //
    }
}
