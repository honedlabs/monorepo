<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\DatePicker;

class AsDatePicker extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(DatePicker::class, ...$arguments);
    }
}