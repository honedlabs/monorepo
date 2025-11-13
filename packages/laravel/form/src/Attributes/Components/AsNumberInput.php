<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Attribute;
use Honed\Form\Components\NumberInput;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AsNumberInput extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(NumberInput::class, ...$arguments);
    }
}
