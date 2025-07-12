<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\Attachable;
use Illuminate\Support\Arr;
use Honed\Action\Contracts\Relatable;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Actions\Concerns\InteractsWithModels;
use Honed\Action\Actions\Concerns\InteractsWithFormData;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TToggle of \Illuminate\Database\Eloquent\Model
 * @template TInput of mixed = array<string, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 */
abstract class ToggleAction extends DatabaseAction implements Relatable
{
    /**
     * @use \Honed\Action\Actions\Concerns\InteractsWithFormData<TInput>
     */
    use InteractsWithFormData;
    use InteractsWithModels;
    use Attachable;

    /**
     * Toggle the models in the relationship.
     *
     * @param  TModel  $model
     * @param  int|string|TToggle|array<int, int|string|TToggle>  $toggles
     * @param  TInput  $attributes
     * @return TModel
     */
    public function handle(Model $model, $toggles, $attributes = []): Model
    {
        $this->transaction(
            fn () => $this->execute($model, $toggles, $attributes)
        );

        return $model;
    }

    /**
     * Prepare the models and attributes for the toggle method.
     *
     * @param  int|string|TToggle|array<int, int|string|TToggle>  $toggles
     * @param  TInput  $attributes
     * @return array<int|string, array<string, mixed>>
     */
    protected function prepare($toggles, $attributes): array
    {
        /** @var array<int, int|string|TToggle> */
        $toggles = $this->arrayable($toggles);

        $attributes = $this->normalize($attributes);

        return Arr::mapWithKeys(
            $toggles,
            fn ($togglement) => [
                $this->getKey($togglement) => $attributes,
            ]
        );
    }

    /**
     * Toggle the models in the relationship.
     *
     * @param  TModel  $model
     * @param  int|string|TToggle|array<int, int|string|TToggle>  $toggles
     * @param  TInput  $attributes
     */
    protected function execute(Model $model, $toggles, $attributes): void
    {
        $toggling = $this->prepare($toggles, $attributes);

        $toggled = $this->getRelationship($model)->toggle($toggling, $this->shouldTouch());

        $this->after($model, $toggled['attached'], $toggled['detached']);
    }

    /**
     * Perform additional logic after the model has been toggleed.
     *
     * @param  TModel  $model
     * @param  array<mixed>  $toggled
     */
    protected function after(Model $model, $attached, $detached): void
    {
        //
    }
}
