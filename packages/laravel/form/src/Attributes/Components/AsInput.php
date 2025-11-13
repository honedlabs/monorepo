<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Attribute;
use Honed\Form\Components\Input;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AsInput extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Input::class, ...$arguments);
    }
}
