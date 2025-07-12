<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Illuminate\Support\Arr;
use Honed\Action\Contracts\FromRelationship;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Actions\Concerns\Attachable;
use Honed\Action\Actions\Concerns\InteractsWithModels;
use Honed\Action\Actions\Concerns\InteractsWithFormData;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAttach of \Illuminate\Database\Eloquent\Model
 * @template TInput of mixed = array<int, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 * 
 * @implements \Honed\Action\Contracts\FromRelationship<TModel, \Illuminate\Database\Eloquent\Relations\BelongsToMany<TModel, TAttach>>
 */
abstract class AttachAction extends DatabaseAction implements FromRelationship
{
    /**
     * @use \Honed\Action\Actions\Concerns\InteractsWithFormData<TInput>
     */
    use InteractsWithFormData;
    use InteractsWithModels;
    /**
     * @use \Honed\Action\Actions\Concerns\Attachable<TModel, TAttach>
     */
    use Attachable;

    /**
     * Attach models to the parent model.
     *
     * @template T of int|string|TAttach|null
     * 
     * @param  TModel  $model
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T>  $attachments
     * @param  TInput  $attributes
     * @return TModel
     */
    public function handle(Model $model, $attachments, $attributes = []): Model
    {
        $this->transaction(
            fn () => $this->execute($model, $attachments, $attributes)
        );

        return $model;
    }

    /**
     * Prepare the attachments and attributes for the attach method.
     *
     * @template T of int|string|TAttach|null
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T>  $attachments
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
     * Execute the action.
     *
     * @template T of int|string|TAttach|null
     * 
     * @param  TModel  $model
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T>  $attachments
     * @param  TInput  $attributes
     */
    protected function execute(Model $model, $attachments, $attributes): void
    {
        /** @var array<int, int|string|TAttach> */
        $attachments = $this->arrayable($attachments);

        $attaching = $this->prepare($attachments, $attributes);

        $this->getRelationship($model)->attach($attaching, touch: $this->touch());

        $this->after($model, $attachments, $attributes);
    }

    /**
     * Perform additional logic after the action has been executed.
     *
     * @template T of int|string|TAttach|null
     * 
     * @param  TModel  $model
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T>  $attachments
     * @param  TInput  $attributes
     */
    protected function after(Model $model, $attachments, $attributes): void
    {
        //
    }
}
