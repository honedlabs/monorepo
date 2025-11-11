<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\NumberInput;

class AsNumberInput extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(NumberInput::class, ...$arguments);
    }
}