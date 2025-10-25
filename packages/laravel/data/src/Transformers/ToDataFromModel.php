<?php

declare(strict_types=1);

namespace Honed\Data\Transformers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;

/**
 * @template TData of \Spatie\LaravelData\Contracts\BaseData&\Spatie\LaravelData\Contracts\TransformableData
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class ToDataFromModel extends FormTransformer
{
    /**
     * @param  class-string<TData>  $data
     * @param  class-string<TModel>  $model
     * @param  list<string>|null  $columns
     */
    public function __construct(
        public string $data,
        public string $model,
        public ?string $column = null,
        public ?array $columns = null
    ) {}

    /**
     * Transform the value to a data object.
     */
    public function toFormData(
        DataProperty $property,
        mixed $value,
        TransformationContext $context
    ): mixed {

        $model = $this->resolveQuery($value)->first($this->columns ?? ['*']);

        if ($property->type->isNullable) {
            return ($this->data)::optional($model)?->toArray();
        }

        return ($this->data)::from($model)->toArray();
    }

    /**
     * Resolve the query to utilise.
     *
     * @return \Illuminate\Database\Eloquent\Builder<TModel>
     */
    protected function resolveQuery(mixed $value): Builder
    {
        $model = $this->getModel();

        /** @var \Illuminate\Database\Eloquent\Builder<TModel> */
        return $model
            ->resolveRouteBindingQuery($model->newQuery(), $value, $this->column);
    }

    /**
     * Get an instance of the model.
     *
     * @return TModel
     */
    protected function getModel(): Model
    {
        return resolve($this->model);
    }
}
