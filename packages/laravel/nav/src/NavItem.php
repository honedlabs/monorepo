<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Primitive;
use Honed\Core\Concerns\Allowable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Honed\Core\Concerns\HasDestination;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Illuminate\Support\Facades\Request;

class NavItem extends Primitive
{
    use HasLabel;
    use Allowable;
    use HasDestination;
    use HasIcon;
    use Concerns\HasRoute;

    /**
     * @var bool|string|\Closure|null
     */
    protected $active;

    public function __construct(string $label, string|\Closure|null $route = null, mixed $parameters = [])
    {
        $this->label($label);
        $this->route($route, $parameters);
    }

    public static function make(string $label, string|\Closure|null $route = null, mixed $parameters = []): static
    {
        return resolve(static::class, compact('label', 'route', 'parameters'));
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'href' => $this->getRoute(),
            'active' => $this->isActive(),
            ...($this->hasIcon() ? ['icon' => $this->getIcon()] : []),
        ];
    }

    /**
     * Set the condition for this nav item to be considered active.
     *
     * @return $this
     */
    public function active(string|\Closure|null $condition): static
    {
        if (! \is_null($condition)) {
            $this->active = $condition;
        }

        return $this;
    }

    /**
     * Determine if this nav item is active.
     */
    public function isActive(): bool
    {
        return false;
        // return (bool) match (true) {
        //     \
        // };
    }
}
