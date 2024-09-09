<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

trait Routable
{
    /**
     * @var string|Closure
     */
    protected $route;

    /**
     * @var mixed
     */
    protected $routeParameters = null;

    /**
     * @var bool|Closure
     */
    protected $isDownloadRoute = false;

    /**
     * @var bool|Closure
     */
    protected $isSignedRoute = false;

    /**
     * @var bool|int
     */
    protected $isTemporaryRoute = false;

    /**
     * Null is _self
     *
     * @var string|Closure|null
     */
    protected $routeTarget = null;

    /**
     * @var string|Closure
     */
    protected $routeMethod = Request::METHOD_GET;

    /**
     * @var string|null
     */
    protected $resolvedRoute = null;

    /**
     * Check if the class is routable
     *
     * @return bool
     */
    public function isRoutable()
    {
        return isset($this->route);
    }

    /**
     * Check if the class is not routable
     *
     * @return bool
     */
    public function isNotRoutable()
    {
        return ! $this->isRoutable();
    }

    /**
     * Check if the route should download the endpoint resource
     *
     * @return bool
     */
    public function isDownloadRoute()
    {
        return $this->evaluate($this->isDownloadRoute);
    }

    /**
     * Check if the route should not download the endpoint resource
     *
     * @return bool
     */
    public function isNotDownloadRoute()
    {
        return ! $this->isDownloadRoute();
    }

    /**
     * Check if the route is a signed route
     *
     * @return bool
     */
    public function isSignedRoute()
    {
        return $this->evaluate($this->isSignedRoute);
    }

    /**
     * Check if the route should not be a signed route
     *
     * @return bool
     */
    public function isNotSignedRoute()
    {
        return ! $this->isSignedRoute();
    }

    /**
     * Check if the route is temporary
     *
     * @return bool
     */
    public function isTemporaryRoute()
    {
        return $this->evaluate($this->isTemporaryRoute);
    }

    /**
     * Check if the route should not be temporary
     *
     * @return bool
     */
    public function isNotTemporaryRoute()
    {
        return ! $this->isTemporaryRoute();
    }

    /**
     * Set the route
     *
     * @return void
     */
    public function setRoute(string|Closure|null $route)
    {
        if (is_null($route)) {
            return;
        }

        $this->route = $route;
    }

    /**
     * Set the route parameters
     *
     * @return void
     */
    public function setRouteParameters(mixed $routeParameters)
    {
        $this->routeParameters = $routeParameters;
    }

    /**
     * Set the route as downloadable
     *
     * @param  bool|Closure|null  $download
     * @return void
     */
    public function setDownload($download)
    {
        if (is_null($download)) {
            return;
        }
        $this->isDownloadRoute = $download;
    }

    /**
     * Set the route to be signed
     *
     * @param  bool|Closure|null  $signed
     * @return void
     */
    public function setSigned($signed)
    {
        if (is_null($signed)) {
            return;
        }
        $this->isSignedRoute = $signed;
    }

    /**
     * Set the route to be temporary
     *
     * @param  bool|Closure|null  $temporary
     * @return void
     */
    public function setTemporary($temporary)
    {
        if (is_null($temporary)) {
            return;
        }
        $this->isTemporaryRoute = $temporary;
    }

    /**
     * Set the route target
     *
     * @param  string|Closure|null  $target
     * @return void
     */
    public function setTarget($target)
    {
        if (is_null($target)) {
            return;
        }

        $this->routeTarget = $target;
    }

    /**
     * Set the route method
     *
     * @param  string|Closure|null  $method
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setMethod($method)
    {
        if (is_null($method)) {
            return;
        }
        if (! in_array($method = mb_strtoupper($method), [
            Request::METHOD_GET,
            Request::METHOD_POST,
            Request::METHOD_PUT,
            Request::METHOD_PATCH,
            Request::METHOD_DELETE,
        ])) {
            throw new InvalidArgumentException("The provided method [{$method}] is not supported.");
        }

        $this->routeMethod = $method;
    }

    /**
     * Get the resolved route
     *
     * @param  mixed  $parameters
     * @return string|null
     */
    public function getRoute($parameters = null)
    {
        if (! $this->isRoutable()) {
            return null;
        }

        return $this->resolvedRoute ??= $this->resolveRoute($parameters);
    }

    /**
     * Get the route parameters
     *
     * @return mixed
     */
    protected function getRouteParameters()
    {
        return $this->evaluate($this->routeParameters);
    }

    /**
     * Get the route HTTP method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->evaluate($this->routeMethod);
    }

    /**
     * Get the route target
     *
     * @return string|null
     */
    public function getTarget()
    {
        return $this->evaluate($this->routeTarget);
    }

    /**
     * Set the route with overriding parameters
     *
     * @param  mixed  $parameters
     * @return static
     */
    public function route(string|Closure $route, $parameters = null)
    {
        $this->setRoute($route);
        $this->setRouteParameters($parameters);

        return $this;
    }

    /**
     * Set the route to download the resource
     *
     * @return static
     */
    public function download(bool|Closure $download = true)
    {
        $this->setDownload($download);

        return $this;
    }

    /**
     * Set the route to be signed
     *
     * @return static
     */
    public function signed(bool|Closure $signed = true)
    {
        $this->setSigned($signed);

        return $this;
    }

    /**
     * Set the route to be temporary
     *
     * @return static
     */
    public function temporary(bool|Closure|int $temporary = true)
    {
        $this->setTemporary($temporary);

        return $this;
    }

    /**
     * Set the route target to in a new tab
     *
     * @return static
     */
    public function newTab()
    {
        return $this->target('_blank');
    }

    /**
     * Set the route target
     *
     * @return static
     */
    public function target(string|Closure|null $target = '_blank')
    {
        $this->setTarget($target);

        return $this;
    }

    /**
     * Set the route method
     *
     * @return static
     */
    public function method(string|Closure $method = Request::METHOD_GET)
    {
        $this->setMethod($method);

        return $this;
    }

    /**
     * Set the route method to GET
     *
     * @return static
     */
    public function get()
    {
        return $this->method(Request::METHOD_GET);
    }

    /**
     * Set the route method to POST
     *
     * @return static
     */
    public function post()
    {
        return $this->method(Request::METHOD_POST);
    }

    /**
     * Set the route method to PUT
     *
     * @return static
     */
    public function put()
    {
        return $this->method(Request::METHOD_PUT);
    }

    /**
     * Set the route method to PATCH
     *
     * @return static
     */
    public function patch()
    {
        return $this->method(Request::METHOD_PATCH);
    }

    /**
     * Set the route method to DELETE
     *
     * @return static
     */
    public function delete()
    {
        return $this->method(Request::METHOD_DELETE);
    }

    /**
     * Check if the route is a named route
     *
     * @return bool
     */
    public function isNamedRoute()
    {
        return ! str($this->route)->startsWith('/');
    }

    /**
     * Resolve the route using the provided parameters
     *
     * @param  mixed  $parameters
     */
    protected function resolveRoute($parameters = null): string
    {

        if (is_callable($route = $this->route)) {
            return url(str(call_user_func($route, $parameters))->replaceFirst(url('/'), ''));
        }

        $use = (is_null($parameters) ? $this->getRouteParameters() : $parameters) ?? [];

        if ($this->isNamedRoute()) {
            return route($route, $use);
        }

        foreach ($use as $key => $value) {
            $route = str_replace(":$key", $value, $route);
        }

        return url(rtrim(preg_replace('/\{[^\}]*\}/', '', $route), '/'));
    }
}
