<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Illuminate\Support\Arr;
use Honed\Action\Contracts\Relatable;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Actions\Concerns\Attachable;
use Honed\Action\Actions\Concerns\InteractsWithModels;
use Honed\Action\Actions\Concerns\InteractsWithFormData;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAttach of \Illuminate\Database\Eloquent\Model
 * @template TInput of mixed = array<int, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 */
abstract class AttachAction extends DatabaseAction implements Relatable
{
    /**
     * @use \Honed\Action\Actions\Concerns\InteractsWithFormData<TInput>
     */
    use InteractsWithFormData;
    use InteractsWithModels;
    use Attachable;

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
        $this->transaction(
            fn () => $this->execute($model, $attachments, $attributes)
        );

        return $model;
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
     * Store the attachments in the database.
     *
     * @param  TModel  $model
     * @param  int|string|TAttach|iterable<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     */
    protected function execute(Model $model, $attachments, $attributes): void
    {
        /** @var array<int, int|string|TAttach> */
        $attachments = $this->arrayable($attachments);

        $attaching = $this->prepare($attachments, $attributes);

        $this->getRelationship($model)->attach($attaching, touch: $this->shouldTouch());

        $this->after($model, $attachments, $attributes);
    }

    /**
     * Perform additional logic after the model has been attached.
     *
     * @param  TModel  $model
     * @param  int|string|TAttach|array<int, int|string|TAttach>  $attachments
     * @param  TInput  $attributes
     */
    protected function after(Model $model, $attachments, $attributes): void
    {
        //
    }
}
