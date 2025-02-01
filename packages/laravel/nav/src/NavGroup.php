<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;
use Illuminate\Support\Collection;

class NavGroup implements Primitive
{
    use HasLabel;
    use Allowable;

    public function __construct(string $label, $route = null, $parameters = [])
    {
        $this->label($label);
    }

    // public 

}
