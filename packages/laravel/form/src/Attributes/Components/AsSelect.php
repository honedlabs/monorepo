<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Components\Select;

class AsSelect extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Select::class, ...$arguments);
    }
}
