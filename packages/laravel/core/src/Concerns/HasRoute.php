<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Exceptions\InvalidMethodException;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

use function in_array;
use function is_string;
use function mb_strtoupper;

trait HasRoute
{
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
     * Whether the route is external, and not within the application.
     *
     * @var bool
     */
    protected $external = false;

    /**
     * Set the route.
     *
     * @param  string|(\Closure(...mixed):string)|null  $route
     * @param  mixed  $parameters
     * @return $this
     */
    public function route($route, $parameters = [])
    {
        $this->route = match (true) {
            ! $route => null,
            $route instanceof Closure => $route,
            $this->isRouteBound($parameters) => fn ($record) => route($route, $record, true),
            default => route($route, $parameters, true),
        };

        return $this;
    }

    /**
     * Set the url.
     *
     * @param  string|(\Closure(...mixed):string)|null  $url
     * @return $this
     */
    public function url($url)
    {
        $this->route = match (true) {
            $url instanceof Closure => $url,
            default => URL::to($url),
        };

        return $this;
    }

    /**
     * Retrieve the route.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return string|null
     */
    public function getRoute($parameters = [], $typed = [])
    {
        return $this->evaluate($this->route, $parameters, $typed);
    }

    /**
     * Determine if a route is set.
     *
     * @return bool
     */
    public function hasRoute()
    {
        return filled($this->route);
    }

    /**
     * Set the HTTP method for the route.
     *
     * @param  string|null  $method
     * @return $this
     *
     * @throws InvalidMethodException
     */
    public function method($method)
    {
        $method = mb_strtoupper($method ?? '');

        if ($this->invalidMethod($method)) {
            InvalidMethodException::throw($method);
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
     * Set whether the route is external.
     *
     * @param  bool  $external
     * @return $this
     */
    public function external($external = true)
    {
        $this->external = $external;

        return $this;
    }

    /**
     * Determine if the route is external.
     *
     * @return bool
     */
    public function isExternal()
    {
        return $this->external;
    }

    /**
     * Get the array representation of the route.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array{url:string|null,method:string}|null
     */
    public function routeToArray($parameters = [], $typed = [])
    {
        $route = $this->getRoute($parameters, $typed);

        if (! $route) {
            return null;
        }

        return [
            'url' => $route,
            'method' => $this->getMethod(),
            'external' => $this->isExternal(),
        ];
    }

    /**
     * Determine if the parameters are a route bound.
     *
     * @param  mixed  $parameters
     * @return bool
     */
    protected function isRouteBound($parameters)
    {
        return is_string($parameters)
            && Str::startsWith($parameters, '{')
            && Str::endsWith($parameters, '}');
    }

    /**
     * Determine if the HTTP method is invalid.
     *
     * @param  string  $method
     * @return bool
     */
    protected function invalidMethod($method)
    {
        return ! in_array($method, [
            Request::METHOD_GET,
            Request::METHOD_POST,
            Request::METHOD_PUT,
            Request::METHOD_DELETE,
            Request::METHOD_PATCH,
        ]);
    }
}
