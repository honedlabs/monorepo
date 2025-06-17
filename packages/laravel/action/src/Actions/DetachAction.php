<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\Action;
use Honed\Action\Contracts\Relatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TDetach of \Illuminate\Database\Eloquent\Model
 */
abstract class DetachAction implements Action, Relatable
{
    use Concerns\CanBeTransaction;
    use Concerns\InteractsWithModels;

    /**
     * Detach models from the parent model.
     *
     * @param  TModel  $model
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     * @return TModel
     */
    public function handle(Model $model, int|string|Model|array $detachments): Model
    {
        $this->transact(
            fn () => $this->detach($model, $detachments)
        );

        return $model;
    }

    /**
     * Get the relation for the model.
     *
     * @param  TModel  $model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<TModel, TDetach>
     */
    protected function getRelation(Model $model): BelongsToMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany<TModel, TDetach> */
        return $model->{$this->relationship()}();
    }

    /**
     * Convert the detachments to an array of keys.
     *
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     * @return array<int, int|string>
     */
    protected function prepare(int|string|Model|array $detachments): array
    {
        $detachments = $this->arrayable($detachments);

        return array_map(
            fn ($attachment) => $this->getKey($attachment),
            $detachments
        );
    }

    /**
     * Store the detachments in the database.
     *
     * @param  TModel  $model
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     * @return void
     */
    protected function detach(Model $model, int|string|Model|array $detachments): void
    {
        $detaching = $this->prepare($detachments);

        $this->getRelation($model)->detach($detaching, $this->shouldTouch());

        $this->after($model, $detachments);
    }

    /**
     * Perform additional logic after the model has been detached.
     *
     * @param  TModel  $model
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     * @return void
     */
    protected function after(Model $model, int|string|Model|array $detachments): void
    {
        //
    }
}
