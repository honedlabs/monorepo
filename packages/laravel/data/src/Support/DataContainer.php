<?php

declare(strict_types=1);

namespace Honed\Data\Support;

use Spatie\LaravelData\Support\DataContainer as SupportDataContainer;

class DataContainer extends SupportDataContainer
{
    protected ?FieldDataResolver $fieldDataResolver = null;

    public function fieldDataResolver(): FieldDataResolver
    {
        return $this->fieldDataResolver ??= app(FieldDataResolver::class);
    }
}
