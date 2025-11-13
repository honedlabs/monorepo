<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Attribute;
use Honed\Form\Components\Radio;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AsRadio extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Radio::class, ...$arguments);
    }
}
