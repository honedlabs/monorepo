<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Attribute;
use Honed\Form\Components\Textarea;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AsTextarea extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Textarea::class, ...$arguments);
    }
}
