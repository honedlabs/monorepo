<?php

namespace Honed\Crumb\Concerns;

use ReflectionMethod;
use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Crumbs as CrumbCrumbs;
use Illuminate\Support\Facades\Route;
use Honed\Crumb\Facades\Crumbs as CrumbsFacade;
use Honed\Crumb\Exceptions\CrumbsNotFoundException;

trait Crumbs
{
    final public function __construct()
    {
        $this->configureCrumbs();
    }

    public function configureCrumbs(): void
    {
        $name = $this->getCrumbName();

        if ($name) {
            CrumbsFacade::get($name)->share();
        }
    }

    public function getCrumbName(): ?string
    {
        return match (true) {
            \property_exists($this, 'cru mb') => $this->crumb,
            (bool) ($c = collect((new \ReflectionMethod($this, Route::getCurrentRoute()->getActionMethod()))
                ->getAttributes(Crumb::class)
            )->first()?->newInstance()->getCrumb()) => $c,
            (bool) ($c = collect((new \ReflectionClass($this))
                ->getAttributes(Crumb::class)
            )->first()?->newInstance()->getCrumb()) => $c,
            \method_exists($this, 'crumb') => $this->crumb,
            default => null,
        };
    }
}
