<?php

declare(strict_types=1);

namespace Honed\Core\Link;

use Honed\Core\Primitive;
use Illuminate\Support\Facades\URL as UrlFacade;
use Symfony\Component\HttpFoundation\Request;

class Link extends Primitive
{
    use Concerns\HasUrlDuration;
    use Concerns\HasMethod;
    use Concerns\HasUrl;
    use Concerns\IsDownloadable;
    use Concerns\IsNamed;
    use Concerns\IsNewTab;
    use Concerns\IsSigned;

    /**
     * @var string|null
     */
    protected $resolvedUrl = null;

    /**
     * Create a new parameterised url instance.
     *
     * @param  string|(\Closure(mixed...):string)|null  $url
     * @param  string|(\Closure():string)  $method
     */
    final public function __construct(
        string|\Closure|null $url = null,
        string|\Closure $method = Request::METHOD_GET,
    ) {
        parent::__construct();
        $this->setUrl($url);
        $this->setMethod($method);
    }

    /**
     * Make a url parameter object.
     *
     * @param  string|(\Closure(mixed...):string)  $url
     * @param  string|(\Closure():string)|null  $method
     */
    public static function make(string|\Closure|null $url = null, string|\Closure|null $method = Request::METHOD_GET): static
    {
        return resolve(static::class, compact('url', 'method'));
    }

    /**
     * Alias for setting a url.
     *
     * @param  string|(\Closure(mixed...):string)  $route
     * @return $this
     */
    public function to($route): static
    {
        $this->setNamed($this->checkIfNamed($route));
        $this->setUrl($route);

        return $this;
    }

    /**
     * Set the signed route, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $route
     * @return $this
     */
    public function signedRoute($route, int|\Carbon\Carbon $duration = 0): static
    {
        $this->setNamed($this->checkIfNamed($route));
        $this->setUrl($route);
        $this->setSigned(true);
        $this->setDuration($duration);

        return $this;
    }

    /**
     * Resolve and retrieve the url.
     *
     * @param  array<string,mixed>  $typed
     */
    public function getResolvedUrl(array $parameters = [], array $typed = []): ?string
    {
        if (! $this->hasUrl()) {
            return null;
        }

        return $this->resolvedUrl ??= $this->resolveUrl($parameters, $typed);
    }

    /**
     * Resolve the url using parameters
     *
     * @param  array<string,mixed>  $typed
     */
    public function resolveUrl(array $parameters = [], array $typed = []): string
    {
        $this->resolvedUrl = match (true) {
            $this->isNotNamed() => $this->getUrl($parameters, $typed),
            $this->isSigned() && $this->isTemporary() => URLFacade::temporarySignedRoute($this->getUrl(), $this->getDuration(), ...$parameters),
            $this->isSigned() => URLFacade::signedRoute($this->getUrl(), ...$parameters),
            default => URLFacade::route($this->getUrl(), ...$parameters),
        };

        return $this->resolvedUrl;
    }

    /**
     * Check if the provided url is a named route. It does not check if the route exists.
     *
     * @internal
     */
    protected function checkIfNamed(string|\Closure|null $url): bool
    {
        // Indeterminate
        if (\is_null($url) || ! \is_string($url)) {
            return false;
        }

        return ! str($url)->startsWith('/') && ! str($url)->startsWith('http');
    }

    public function toArray()
    {
        return [
            'url' => $this->getResolvedUrl(),
            'method' => $this->getMethod(),
        ];
    }
}
