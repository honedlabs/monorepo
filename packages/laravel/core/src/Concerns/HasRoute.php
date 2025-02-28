<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

trait HasRoute
{
    public const ValidMethods = [
        Request::METHOD_GET,
        Request::METHOD_POST,
        Request::METHOD_PUT,
        Request::METHOD_DELETE,
        Request::METHOD_PATCH,
    ];

    /**
     * @var string|\Closure|null
     */
    protected $route;

    /**
     * @var bool
     */
    protected $external = false;

    /**
     * @var string
     */
    protected $method = Request::METHOD_GET;

    /**
     * Set the route for this instance.
     *
     * @param  string|\Closure|null  $route
     * @param  array<string,mixed>  $parameters
     * @return $this
     */
    public function route($route, $parameters = [])
    {
        if (! \is_null($route)) {
            $this->route = match (true) {
                \is_string($route) => route($route, $parameters, true),
                $route instanceof \Closure => $route,
            };
        }

        return $this;
    }

    /**
     * Set the url for this instance.
     *
     * @param  string|\Closure|null  $url
     * @return $this
     */
    public function url($url)
    {
        if (! \is_null($url)) {
            $this->route = $url instanceof \Closure
                ? $url
                : URL::to($url);
        }

        return $this;
    }

    /**
     * Set the HTTP method for the route.
     *
     * @param  string|null  $method
     * @return $this
     */
    public function method($method)
    {
        if (\is_null($method)) {
            return $this;
        }

        $method = \mb_strtoupper($method);

        if (! \in_array($method, self::ValidMethods)) {
            throw new \InvalidArgumentException("The provided method [{$method}] is not a valid HTTP method.");
        }

        $this->method = $method;

        return $this;
    }

    /**
     * Mark the route as being an external url.
     *
     * @param  string|null  $url
     * @return $this
     */
    public function external($url = null)
    {
        $this->external = true;

        return $this->url($url);
    }

    /**
     * Determine if the route is set.
     *
     * @return bool
     */
    public function hasRoute()
    {
        return ! \is_null($this->route);
    }

    /**
     * Determine if the route points to an external link.
     *
     * @return bool
     */
    public function isExternal()
    {
        return $this->external;
    }

    /**
     * Retrieve the route for this instance, resolving any closures.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return string|null
     */
    public function getRoute($parameters = [], $typed = [])
    {
        return $this->evaluate($this->route, $parameters, $typed);
    }

    /**
     * Evaluate the route for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return string|null
     */
    public function resolveRoute(array $parameters = [], array $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->route, $parameters, $typed);

        $this->route = $evaluated;

        return $evaluated;
    }

    /**
     * Get the HTTP method for the route.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}
