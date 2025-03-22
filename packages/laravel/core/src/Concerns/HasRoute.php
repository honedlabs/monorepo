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
     * The route.
     *
     * @var string|\Closure(...mixed):string|null
     */
    protected $route;

    /**
     * The HTTP method for the route.
     *
     * @var string
     */
    protected $method = Request::METHOD_GET;

    /**
     * Set the route.
     *
     * @param  string|\Closure(...mixed):string  $route
     * @param  array<string,mixed>  $parameters
     * @return $this
     */
    public function route($route, $parameters = [])
    {
        $this->route = match (true) {
            $route instanceof \Closure => $route,
            default => route($route, $parameters, true),
        };

        return $this;
    }

    /**
     * Set the url.
     *
     * @param  string|\Closure(...mixed):string|null  $url
     * @return $this
     */
    public function url($url)
    {
        $this->route = match (true) {
            $url instanceof \Closure => $url,
            default => URL::to($url),
        };

        return $this;
    }

    /**
     * Retrieve the route.
     *
     * @return string|null
     */
    public function getRoute()
    {
        return $this->evaluate($this->route);
    }

    /**
     * Resolve the route.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return string|null
     */
    public function resolveRoute($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->route, $parameters, $typed);

        return $evaluated;
    }

    /**
     * Determine if the route is set.
     *
     * @return bool
     */
    public function hasRoute()
    {
        return isset($this->route);
    }

    /**
     * Set the HTTP method for the route.
     *
     * @param  string|null  $method
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function method($method)
    {
        if (\is_null($method)) {
            $method = '';
        }

        $method = \mb_strtoupper($method);

        if (! \in_array($method, self::ValidMethods)) {
            throw new \InvalidArgumentException(\sprintf(
                'The provided method [%s] is not a valid HTTP method.',
                $method
            ));
        }

        $this->method = $method;

        return $this;
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

    /**
     * Get the array representation of the route.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>|null
     */
    public function routeToArray($parameters = [], $typed = [])
    {
        if (! $this->hasRoute()) {
            return null;
        }

        return [
            'route' => $this->resolveRoute($parameters, $typed),
            'method' => $this->getMethod(),
        ];
    }
}
