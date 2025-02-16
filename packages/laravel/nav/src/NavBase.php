<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Primitive;

/**
 * @extends Primitive<string, mixed>
 */
abstract class NavBase extends Primitive
{
    use Allowable;
    use HasLabel;
    use HasIcon;

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
        ];
    }
}
