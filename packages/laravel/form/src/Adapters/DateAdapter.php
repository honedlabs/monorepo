<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Components\Component;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

class DateAdapter implements DataAdapter
{
    public function getComponent(DataProperty $property, DataClass $dataClass): ?Component
    {
        if ($property->attributes->has())
        return null;
    }
}