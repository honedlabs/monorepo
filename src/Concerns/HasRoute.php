<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;
use Illuminate\Support\Facades\Route;

trait HasRoute
{
    protected string|Closure|null $route = null;

    protected ?string $resolvedRoute = null;

    public function route(string|Closure $route): static
    {
        $this->setRoute($route);

        return $this;
    }

    public function setRoute(string|Closure|null $route): void
    {
        if (is_null($route)) return;
        $this->route = $route;
    }

    public function getRoute(): string|Closure|null
    {
        return $this->route;
    }

    public function hasRoute(): bool
    {
        return ! is_null($this->route);
    }

    public function lacksRoute(): bool
    {
        return ! $this->hasRoute();
    }

    public function resolveRoute(mixed $parameters = []): ?string
    {
        if (! $this->hasRoute()) {
            return null;
        }

        $route = $this->getRoute();

        if (is_callable($route)) {
            $route = call_user_func($route, $parameters);
        }

        if (Route::has($route)) {
            return route($route, $parameters);
        }

        foreach ($parameters as $key => $value) {
            $route = str_replace(":$key", $value, $route);
        }

        $route = preg_replace('/\{[^\}]*\}/', '', $route);

        return url(rtrim($route, '/'));
    }

    public function getResolvedRoute(mixed $parameters = []): ?string
    {
        return $this->resolvedRoute ??= $this->resolveRoute($parameters);
    }
}
