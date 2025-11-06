<?php

declare(strict_types=1);

namespace App\Forms\Components;

use BackedEnum;
use Honed\Form\Components\Field;

class Combobox extends Field
{
    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return 'combobox';
    }
}
