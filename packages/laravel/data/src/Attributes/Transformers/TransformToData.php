<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Transformers;

use Attribute;
use Honed\Data\Transformers\ToData;
use Honed\Data\Transformers\ToDataFromModel;
use Spatie\LaravelData\Attributes\WithTransformer;

/**
 * @template TData of \Spatie\LaravelData\Contracts\BaseData
 *
 * @property-read class-string<TData> $transformerClass
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class TransformToData extends WithTransformer
{
    /**
     * @param  class-string<TData>  $data
     * @param  list<string>|null  $columns
     */
    public function __construct(
        string $data,
        ?string $model = null,
        ?string $column = null,
        ?array $columns = null
    ) {

        if ($model === null) {
            parent::__construct(ToData::class, $data);
        } else {
            parent::__construct(ToDataFromModel::class, $data, $model, $column, $columns);
        }
    }
}
