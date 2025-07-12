<?php

declare(strict_types=1);

namespace Honed\Action\Actions\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Workbench\App\Models\Product;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAttach of \Illuminate\Database\Eloquent\Model
 * @template TInput of mixed = array<int, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 * 
 * @phpstan-require-implements \Honed\Action\Contracts\Relatable
 * @phpstan-require-extends \Honed\Action\Actions\DatabaseAction
 */
trait Attachable
{
    /**
     * @use \Honed\Action\Actions\Concerns\InteractsWithFormData<TInput>
     */
    use InteractsWithFormData;
    use InteractsWithModels;

    /**
     * Handle the attachable action.
     *
     * @param  TModel  $model
     * @param  int|string|TAttach|array<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     */
    abstract protected function attachable(Model $model, $attachments, $attributes): void;

    /**
     * Perform the action on a belongs to many relationship.
     *
     * @param  TModel  $model
     * @param  int|string|TAttach|array<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     * @return TModel
     */
    public function handle(Model $model, $attachments, $attributes = [])
    {
        $this->transact(
            fn () => $this->attachable($model, $attachments, $attributes)
        );

        return $model;
    }

    /**
     * Get the relation for the model.
     *
     * @param  TModel  $model
     * @return BelongsToMany<TModel, TAttach>
     */
    protected function getRelationship(Model $model): BelongsToMany
    {
        /** @var BelongsToMany<TModel, TAttach> */
        return $model->{$this->relationship()}();
    }

    /**
     * Prepare the attachments and attributes for the attach method.
     *
     * @param  int|string|TAttach|array<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     * @return array<int|string, array<string, mixed>>
     */
    protected function prepare($attachments, $attributes): array
    {
        /** @var array<int, int|string|TAttach> */
        $attachments = $this->arrayable($attachments);

        /** @var array<string, mixed> */
        $attributes = $this->only(
            $this->normalize($attributes)
        );

        return Arr::mapWithKeys(
            $attachments,
            fn ($attachment) => [
                $this->getKey($attachment) => $attributes,
            ]
        );
    }

    /**
     * Perform additional logic after the model has been synced without detaching.
     *
     * @param  TModel  $model
     * @param  int|string|TAttach|array<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     */
    protected function after(Model $model, $attachments, $attributes)
    {
        //
    }
}