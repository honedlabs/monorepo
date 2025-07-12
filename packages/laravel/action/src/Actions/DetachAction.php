<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\Attachable;
use Honed\Action\Contracts\FromRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Honed\Action\Actions\Concerns\InteractsWithModels;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TDetach of \Illuminate\Database\Eloquent\Model
 * 
 * @implements \Honed\Action\Contracts\FromRelationship<TModel, BelongsToMany<TModel, TDetach>>
 */
abstract class DetachAction extends DatabaseAction implements FromRelationship
{
    use InteractsWithModels;
    use Attachable;

    /**
     * Detach models from the parent model.
     *
     * @param  TModel  $model
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     * @return TModel
     */
    public function handle(Model $model, $detachments): Model
    {
        $this->transaction(
            fn () => $this->execute($model, $detachments)
        );

        return $model;
    }

    /**
     * Convert the detachments to an array of keys.
     *
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     * @return array<int, int|string>
     */
    protected function prepare($detachments): array
    {
        /** @var array<int, int|string|TDetach> */
        $detachments = $this->arrayable($detachments);

        return array_map(
            fn ($attachment) => $this->getKey($attachment),
            $detachments
        );
    }

    /**
     * Execute the action.
     *
     * @param  TModel  $model
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     */
    protected function execute(Model $model, $detachments): void
    {
        $detaching = $this->prepare($detachments);

        $this->getRelationship($model)->detach($detaching, $this->touch());

        $this->after($model, $detachments);
    }

    /**
     * Perform additional logic after the action has been executed.
     *
     * @param  TModel  $model
     * @param  int|string|TDetach|array<int, int|string|TDetach>  $detachments
     */
    protected function after(Model $model, $detachments): void
    {
        //
    }
}
