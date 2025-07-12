<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\Attachable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Honed\Action\Contracts\Relatable;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Actions\DatabaseAction;
use Honed\Action\Actions\Concerns\InteractsWithModels;
use Honed\Action\Actions\Concerns\InteractsWithFormData;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAttach of \Illuminate\Database\Eloquent\Model
 * @template TInput of mixed = array<int, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 */
abstract class AttachUniqueAction extends DatabaseAction implements Relatable
{
    /**
     * @use \Honed\Action\Actions\Concerns\Attachable<TModel, TAttach, TInput>
     */
    // use Attachable;

    /**
     * Attach models to the parent model.
     *
     * @param  TModel  $model
     * @param  int|string|TAttach|iterable<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     * @return TModel
     */
    public function handle(Model $model, $attachments, $attributes = []): Model
    {
        $this->call(
            fn () => $this->perform($model, $attachments, $attributes)
        );

        return $model;
    }


    /**
     * Sync models to the parent without detaching, using attach.
     * 
     * @param  TModel  $model
     * @param  int|string|TAttach|array<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     * @return TModel
     */
    protected function perform(Model $model, $attachments, $attributes): void
    {
        $relation = $this->getRelationship($model);

        $existing = $this->getExisting($model)->all();

        $relation->attach(
            array_diff($attachments, $existing),
            $attributes,
        );

        $this->after($model, $attachments, $attributes);
    }

    /**
     * Get the existing attachments for the model.
     *
     * @param  TModel  $model
     * @return Collection<int, int|string>
     */
    protected function getExisting(Model $model): Collection
    {
        return $this->getRelationship($model)
            ->getQuery()
            ->getQuery()
            ->pluck('id');
    }
}