<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Attributes\Component;
use Honed\Form\Components\Checkbox;

class AsCheckbox extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Checkbox::class, ...$arguments);
    }
}
