<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\InteractsWithFormData;
use Honed\Action\Contracts\RequiresModel;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TInput of mixed = array<string, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 * 
 * @implements \Honed\Action\Contracts\RequiresModel<TModel>
 */
abstract class StoreAction extends DatabaseAction implements RequiresModel
{
    /**
     * @use \Honed\Action\Actions\Concerns\InteractsWithFormData<TInput>
     */
    use InteractsWithFormData;

    /**
     * Store the input data in the database.
     *
     * @param  TInput  $input
     * @return TModel $model
     */
    public function handle($input): Model
    {
        return $this->call(
            fn () => $this->store($input)
        );
    }

    /**
     * Prepare the input for the update method.
     *
     * @param  TInput  $input
     * @return array<string, mixed>
     */
    protected function prepare($input): array
    {
        return $this->only(
            $this->normalize($input)
        );
    }

    /**
     * Store the record in the database.
     *
     * @param  TInput  $input
     * @return TModel
     */
    protected function store($input): Model
    {
        $prepared = $this->prepare($input);

        $class = $this->model();

        $model = (new $class())->query()->create($prepared);

        $this->after($model, $input, $prepared);

        return $model;
    }

    /**
     * Perform additional database transactions after the model has been updated.
     *
     * @param  TModel  $model
     * @param  TInput  $input
     * @param  array<string, mixed>  $prepared
     */
    protected function after(Model $model, $input, $prepared): void
    {
        //
    }
}
