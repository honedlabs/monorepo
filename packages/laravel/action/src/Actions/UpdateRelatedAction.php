<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\InteractsWithFormData;
use Honed\Action\Contracts\FromRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TRelated of \Illuminate\Database\Eloquent\Model
 * @template TRelation of \Illuminate\Database\Eloquent\Relations\Relation = \Illuminate\Database\Eloquent\Relations\Relation
 * @template TInput of mixed = array<string, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest
 *
 * @implements \Honed\Action\Contracts\FromRelationship<TModel, TRelation>
 */
abstract class UpdateRelatedAction extends DatabaseAction implements FromRelationship
{
    /**
     * @use \Honed\Action\Actions\Concerns\InteractsWithFormData<TInput>
     */
    use InteractsWithFormData;

    /**
     * Update the related model.
     *
     * @param  TModel  $model
     * @param  TInput  $input
     * @return TModel
     */
    public function handle(Model $model, $input = []): Model
    {
        return $this->transaction(
            fn () => $this->execute($model, $input)
        );
    }

    /**
     * Execute the action.
     *
     * @param  TModel  $model
     * @param  TInput  $input
     * @return TModel
     */
    public function execute(Model $model, $input): Model
    {
        $relationship = $this->getRelationship($model);

        if ($relationship instanceof BelongsToMany) {
            /** @var \Illuminate\Database\Eloquent\Builder<TRelated> */
            $relationship = $relationship->getQuery();
        } else {
            /** @var TRelated|null */
            $relationship = $relationship->getResults();
        }

        $attributes = $this->attributes($model, $relationship, $input);

        $relationship?->update($attributes);

        $this->after($model, $relationship, $input, $attributes);

        return $model;
    }

    /**
     * Prepare the input for the update method.
     *
     * @param  TModel  $model
     * @param  null|TRelated|\Illuminate\Database\Eloquent\Builder<TRelated>  $relationship
     * @param  TInput  $input
     * @return array<string, mixed>
     */
    public function attributes(Model $model, $relationship, $input): array
    {
        return $this->normalize($input);
    }

    /**
     * Perform additional logic after the action has been executed.
     *
     * @param  TModel  $model
     * @param  null|TRelated|\Illuminate\Database\Eloquent\Builder<TRelated>  $relationship
     * @param  TInput  $input
     * @param  array<string, mixed>  $prepared
     */
    public function after(Model $model, $relationship, $input, array $prepared): void
    {
        //
    }
}
