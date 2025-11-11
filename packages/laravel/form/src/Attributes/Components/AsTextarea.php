<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Components\Textarea;

class AsTextarea extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Textarea::class, ...$arguments);
    }
}
