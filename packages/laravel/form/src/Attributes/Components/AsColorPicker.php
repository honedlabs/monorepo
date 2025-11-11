<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Attributes\Component;
use Honed\Form\Components\ColorPicker;

class AsColorPicker extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(ColorPicker::class, ...$arguments);
    }
}
