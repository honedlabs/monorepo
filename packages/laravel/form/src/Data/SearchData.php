<?php

declare(strict_types=1);

namespace Honed\Form\Data;

use Honed\Core\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Resource;

class SearchData extends Resource
{
    public function __construct(
        public mixed $value,
        public string $label
    ) {}

    /**
     * Create a new search data instance from a model.
     * 
     * If the `HasLabel` is not implemented, the `title` attribute will be
     * assumed to be the name of the model.
     */
    public static function fromModel(Model $model): static
    {
        return new self(
            value: $model->getKey(),
            label: $model instanceof HasLabel ? $model->getLabel() : $model->name
        );
    }
}

