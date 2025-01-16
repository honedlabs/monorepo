<?php

declare(strict_types=1);

namespace Honed\Refining\Sorts;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\IsDefault;
use Honed\Core\Concerns\HasAttribute;
use Honed\Refining\Contracts\Refines;
use Honed\Refining\Refiner;

class Sort extends Refiner
{
    use IsDefault;

    public function isActive(): bool
    {
        return $this->getValue();
    }
}
