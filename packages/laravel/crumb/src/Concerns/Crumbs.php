<?php

declare(strict_types=1);

namespace Honed\Crumb\Concerns;

use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Exceptions\ClassDoesNotExtendControllerException;
use Honed\Crumb\Facades\Crumbs as CrumbFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

trait Crumbs
{
    public function __construct()
    {
        $this->configureCrumbs();
    }

    /**
     * Share the crumbs relevant to the current request to your Inertia view.
     *
     * @throws ClassDoesNotExtendControllerException
     */
    public function configureCrumbs(): void
    {
        if (! \in_array('Illuminate\Routing\Controller', \class_parents($this))) {
            static::throwControllerExtensionException(\class_basename($this));
        }

        $this->middleware(function (Request $request, \Closure $next) {
            $name = $this->getCrumbName();

            // If no, don't share breadcrumbs and don't error.
            if ($name) {
                CrumbFacade::get($name)->share();
            }

            return $next($request);
        });
    }

    /**
     * Retrieve the crumb name to use from the method call, or class instance.
     */
    public function getCrumbName(): ?string
    {
        // dd($this->getCrumbFromMethod());
        if ($crumb = $this->getCrumbFromMethod()) {
            return $crumb->getName();
        }

        return match (true) {
            (bool) ($c = collect((new \ReflectionClass($this))
                ->getAttributes(Crumb::class)
            )->first()?->newInstance()->getCrumb()) => $c,

            (bool) ($c = collect((new \ReflectionClass($this))
                ->getAttributes(Crumb::class)
            )->first()?->newInstance()->getCrumb()) => $c,

            isset($this->crumb) => $this->crumb,

            method_exists($this, 'crumb') => $this->crumb(),
            default => null,
        };
    }

    protected function getCrumbFromMethod(): ?Crumb
    {
        $action = Route::getCurrentRoute()?->getActionMethod();

        if (! $action) {
            return null;
        }

        $crumb = Arr::first(
            (new \ReflectionMethod($this, $action))->getAttributes(Crumb::class),
            static fn (\ReflectionAttribute $attribute) => $attribute->newInstance()->getCrumb()
        );

        return $crumb;
    }
    
    

    /**
     * Throw an exception for when the using class is not a controller.
     */
    protected static function throwControllerExtensionException(string $class): never
    {
        throw new \LogicException(\sprintf(
            'Class [%s] does not extend the [Illuminate\Routing\Controller] controller class.',
            $class
        ));
    }
}
