<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

use Honed\Form\Components\Component;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

interface PropertyAdapter
{
    /**
     * Get the form component for the data property.
     */
    public function getPropertyComponent(DataProperty $property, DataClass $dataClass): ?Component;
}
