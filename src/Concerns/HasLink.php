<?php

namespace Honed\Crumb\Concerns;

/**
 * @method evaluate(mixed $value, array<string,mixed> $named = [], array<string,mixed> $typed = [])
 */
trait HasLink
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $link;

    /**
     * Set the route name and parameters to resolve the url
     */
    public function setRoute(string $name, mixed $parameters = [], bool $absolute = true): void
    {
        $this->link = route($name, $parameters, $absolute);
    }

    /**
     * Set the route name and parameters, chainable
     *
     *
     * @return $this
     */
    public function route(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        $this->setRoute($name, $parameters, $absolute);

        return $this;
    }

    /**
     * Set the url quietly.
     *
     * @param  string|(\Closure(mixed...):string)  $url
     */
    public function setUrl(string|\Closure $url): void
    {
        $this->link = $url;
    }

    /**
     * Set the url, chainable
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
     * Set the link quietly
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
            $this->isUrl($link) => $this->setUrl($link),
            default => $this->setRoute($link, $parameters, $absolute),
        };
    }

    /**
     * Set the link, chainable
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
     * Determine if the link is a url, or a named route.
     *
     * @internal
     */
    private function isUrl(string $link): bool
    {
        return str($link)->startsWith(['http', 'https', '/', '#', 'www.']);
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
}
