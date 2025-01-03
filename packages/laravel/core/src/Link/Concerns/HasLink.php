<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

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
     * @var non-empty-array<int,array<string,mixed>>|null
     */
    protected $parameters;

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
            Str::isUrl($link) => $this->setUrl($link),
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
    }

    /**
     * Set the link as a route quietly.
     *
     * @param  array<array-key, mixed>  $parameters
     */
    public function setRoute(string $name, mixed $parameters = [], bool $absolute = true): void
    {
        $this->link = route($name, $parameters, $absolute);
    }

    /**
     * Retrieve the link, evaluating it if it is a closure.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getLink(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->link, $named, $typed);
    }

    /**
     * Determine if there is a link.
     */
    public function hasLink(): bool
    {
        return ! \is_null($this->link);
    }
}
