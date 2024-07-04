<?php

namespace Conquest\Core\Concerns;

use Closure;
use Illuminate\Support\Facades\Route;

trait HasRoute
{
    protected string|Closure|null $route = null;
    protected string|null $resolvedRoute = null;

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
        return $this->route;
    }

    public function hasRoute(): bool
    {
        return !is_null($this->route);
    }

    public function resolveRoute(mixed $parameters = []): void
    {
        if (!$this->hasRoute()) return;

        $route = $this->getRoute();

        if (is_callable($route)) {
            $this->setResolvedRoute(call_user_func($route, $parameters));
            return;
        }

        // Check if it's a named route
        if (Route::has($route)) {
            $this->setResolvedRoute(route($this->route, $parameters));
            return;
        }

        // Replace parameters in the URL
        foreach ($parameters as $key => $value) {
            $route = str_replace(":$key", $value, $route);
        }

        $route = preg_replace('/\{[^\}]*\}/', '', $route);
        $this->setResolvedRoute(rtrim($route, '/'));
    }

    public function getResolvedRoute(): string
    {
        return $this->resolvedRoute;
    }

    protected function setResolvedRoute(string $route): void
    {
        $this->resolvedRoute = $route;
    }
}