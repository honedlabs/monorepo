<?php

declare(strict_types=1);

namespace App\Concerns;

use Closure;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

trait Routable
{
    /**
     * @var string|Closure
     */
    protected $route;

    /**
     * @var array<string, string|int|array<string, string|int>>
     */
    protected $routeParameters = [];

    /**
     * @var bool|Closure
     */
    protected $isDownloadRoute = false;

    /**
     * @var bool|Closure
     */
    protected $isSignedRoute = false;

    /**
     * @var bool|integer
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
     * @param string|Closure|null $route
     * @return void
     */
    public function setRoute(string|Closure|null $route)
    {
        if (is_null($route)) return;

        $this->route = $route;
    }

    /**
     * Set the route parameters
     * 
     * @param array<string, string|int|array<string, string|int>> $routeParameters
     * @return void
     */
    public function setRouteParameters(array $routeParameters)
    {
        $this->routeParameters = $routeParameters;
    }

    /**
     * Set the route as downloadable
     * 
     * @param bool|Closure|null $download
     * @return void
     */
    public function setDownload($download)
    {
        if (is_null($download)) return;
        $this->isDownloadRoute = $download;
    }

    /**
     * Set the route to be signed
     * 
     * @param bool|Closure|null $signed
     * @return void
     */
    public function setSigned($signed)
    {
        if (is_null($signed)) return;
        $this->isSignedRoute = $signed;
    }

    /**
     * Set the route to be temporary
     * 
     * @param bool|Closure|null $temporary
     * @return void
     */
    public function setTemporary($temporary)
    {
        if (is_null($temporary)) return;
        $this->isTemporaryRoute = $temporary;
    }

    /**
     * Set the route target
     * 
     * @param string|Closure|null $target
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
     * @param string|Closure|null $method
     * @throws InvalidArgumentException
     * @return void
     */
    public function setMethod($method)
    {
        if (is_null($method)) {
            return;
        }
        if (! in_array(mb_strtoupper($method), [Request::METHOD_GET, Request::METHOD_POST, Request::METHOD_PUT, Request::METHOD_PATCH, Request::METHOD_DELETE])) {
            throw new InvalidArgumentException("The provided method [{$method}] is not supported.");
        }

        $this->routeMethod = $method;
    }

    


    // public function route(string|Closure|null $route, ...$parameters)
}