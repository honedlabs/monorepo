<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Components\Component;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

class DefaultAdapter implements DataAdapter
{
    public function getComponent(DataProperty $property, DataClass $dataClass): ?Component
    {
        return null;
    }
}
