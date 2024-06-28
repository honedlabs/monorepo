<?php

namespace Conquest\Core\Concerns;

use Closure;
use Illuminate\Support\Facades\Route;
use Conquest\Core\Exceptions\CannotResolveRoute;

trait HasRoute
{
    protected string|Closure|null $route = null;

    public function route(string|Closure $route): static
    {
        $this->setRoute($route);
        return $this;
    }

    protected function setRoute(string|Closure|null $route): void
    {
        if (is_null($route)) return;
        $this->route = $route;
    }

    public function getRoute(): ?string
    {
        return $this->evaluate($this->route);
    }

    public function hasRoute(): bool
    {
        return !is_null($this->route);
    }

    public function resolveRoute(mixed $parameters = []): string
    {
        if (!$this->hasRoute()) {
            throw new CannotResolveRoute($this);
        }

        $route = $this->getRoute();
        // Check if it's a named route
        if (Route::has($route)) {
            return route($this->route, $parameters);
        }

        // Replace parameters in the URL
        foreach ($parameters as $key => $value) {
            $url = str_replace(":$key", $value, $route);
        }

        $route = preg_replace('/\{[^\}]*\}/', '', $route);
        return rtrim($route, '/');
    }
}