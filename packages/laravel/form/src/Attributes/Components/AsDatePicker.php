<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Attribute;
use Honed\Form\Components\DatePicker;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AsDatePicker extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(DatePicker::class, ...$arguments);
    }
}
