<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;

class NavGroup implements Primitive
{
    use Concerns\HasNavItems;
    use HasLabel;
    use Allowable;

    public function __construct(string $label, ...$items)
    {
        $this->label($label);
    }

    public static function make(string $label, $route = null, $parameters = []): static
    {
        return resolve(static::class, compact('label', 'route', 'parameters'));
    }

    /**
     * @return array<int,mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'items' => $this->getItems(),
        ];
    }
}
