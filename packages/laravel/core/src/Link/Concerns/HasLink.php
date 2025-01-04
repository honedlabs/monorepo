<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasLink
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $link = null;

    /**
     * @var mixed
     */
    protected $parameters = null;

    /**
     * @var bool
     */
    protected $absolute = true;

    /**
     * Set the link, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $link
     * @param  array<array-key, mixed>  $parameters
     * @return $this
     */
    public function link(string|\Closure $link, mixed $parameters = [], bool $absolute = true): static
    {
        $this->setLink($link, $parameters, $absolute);

        return $this;
    }

    /**
     * Set the url, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $url
     * @return $this
     */
    public function url(string|\Closure $url): static
    {
        $this->setUrl($url);

        return $this;
    }

    /**
     * Set the route as a route, chainable.
     *
     * @param  array<array-key, mixed>  $parameters
     * @return $this
     */
    public function route(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        $this->setRoute($name, $parameters, $absolute);

        return $this;
    }

    /**
     * Set the link quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $link
     * @param  array<array-key, mixed>  $parameters
     */
    public function setLink(string|\Closure|null $link, mixed $parameters = [], bool $absolute = true): void
    {
        if (\is_null($link)) {
            return;
        }

        match (true) {
            \is_callable($link) => $this->link = $link,
            Str::isUrl($link) || Str::startsWith($link, '/') || $link === '#' => $this->setUrl($link),
            default => $this->setRoute($link, $parameters, $absolute),
        };
    }

    /**
     * Set the link as a url quietly.
     *
     * @param  string|(\Closure(mixed...):string)  $url
     */
    public function setUrl(string|\Closure $url): void
    {
        $this->link = $url;
        $this->named = false;
    }

    /**
     * Set the link as a route quietly.
     *
     * @param  array<array-key, mixed>  $parameters
     */
    public function setRoute(string $name, mixed $parameters = null, bool $absolute = true): void
    {
        $this->named = true;

        if (! \is_null($parameters)) {
            $this->link = route($name, $parameters, $absolute);

            return;
        }

        $this->link = $name;
        $this->absolute = $absolute;
    }

    /**
     * Retrieve the link, evaluating it if it is a closure.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getLink(array $named = [], array $typed = []): ?string
    {
        if (\is_callable($this->link) && \count($named) === 0 && \count($typed) === 0) {
            [$named, $typed] = $this->getClosureParameters();
        }

        return $this->evaluate($this->link, $named, $typed);
    }

    /**
     * Resolve the link using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveLink(array $named = [], array $typed = []): ?string
    {
        $link = $this->getLink($named, $typed);
        $this->setLink($link);

        return $link;
    }

    /**
     * Determine if there is a link.
     */
    public function hasLink(): bool
    {
        return ! \is_null($this->link);
    }

    /**
     * Get the binding parameters from the current route action.
     *
     * @return non-empty-array<int,array<string,mixed>>
     */
    public function getClosureParameters(): array
    {
        $currentRoute = Route::current();
        $routeParameters = $currentRoute?->parameters() ?? [];
        $request = request();

        $typeHintedParameters = $this->mapParametersToTypes(\array_values($routeParameters));

        return [
            [
                'request' => $request,
                'route' => $currentRoute,
                ...$routeParameters,
            ],
            [
                Request::class => $request,
                Route::class => $currentRoute,
                ...$typeHintedParameters,
            ],
        ];
    }

    /**
     * Map parameter values to their corresponding types or class names.
     *
     * @param  array<int,mixed>  $parameters
     * @return array<string,mixed>
     */
    private function mapParametersToTypes(array $parameters): array
    {
        return \array_combine(
            \array_map(
                static fn ($value): string => \is_object($value)
                    ? \get_class($value)
                    : \gettype($value),
                $parameters
            ),
            $parameters
        ) ?: [];
    }
}
