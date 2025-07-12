<?php

declare(strict_types=1);

namespace App\Actions\Template;

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
 * Optimized action to use in place of syncWithoutDetaching.
 * 
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAttach of \Illuminate\Database\Eloquent\Model
 * @template TInput of mixed = array<int, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 */
abstract class AttachUniqueAction extends DatabaseAction implements Relatable
{
    /**
     * @use \Honed\Action\Actions\Concerns\Attachable<TModel, TAttach, TInput>
     */
    use Attachable;

    /**
     * Sync models to the parent without detaching, using attach.
     * 
     * @param  TModel  $model
     * @param  int|string|TAttach|array<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     * @return TModel
     */
    protected function attachable(Model $model, $attachments, $attributes)
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