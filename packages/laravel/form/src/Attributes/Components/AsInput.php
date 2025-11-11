<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Input;

class AsInput extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Input::class, ...$arguments);
    }
}