<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Exceptions\InvalidMethodException;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

use function in_array;
use function is_string;
use function mb_strtoupper;

trait HasUrl
{
    /**
     * The route to visit.
     *
     * @var string|\Closure(...mixed):string|null
     */
    protected $url;

    /**
     * The method for visiting the URL.
     *
     * @var string
     */
    protected $method = Request::METHOD_GET;

    /**
     * Set the url to visit.
     *
     * @param  string|(\Closure(...mixed):string)|null  $url
     * @param  mixed  $parameters
     * @return $this
     */
    public function url($url, $parameters = [])
    {
        $this->url = match (true) {
            ! $url => null,
            $url instanceof Closure => $url,
            $this->implicitRoute($parameters) => fn ($record) => route($url, $record, true),
            Str::startsWith($url, ['http://', 'https://', '/']) => URL::to($url),
            default => route($url, $parameters, true),
        };

        return $this;
    }

    /**
     * Retrieve the route.
     *
     * @param  array<string,mixed>  $named
     * @param  array<class-string,mixed>  $typed
     * @return string|null
     */
    public function getUrl($named = [], $typed = [])
    {
        return $this->evaluate($this->url, $named, $typed);
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
            throw new InvalidArgumentException(
                "The provided method [{$method}] is invalid."
            );
        }

        $this->method = $method;

        return $this;
    }

    /**
     * Set the visiting method to be a POST request.
     *
     * @return $this
     */
    public function post()
    {
        return $this->method(Request::METHOD_POST);
    }

    /**
     * Set the visiting method to be a PATCH request.
     *
     * @return $this
     */
    public function patch()
    {
        return $this->method(Request::METHOD_PATCH);
    }

    /**
     * Set the visiting method to be a PUT request.
     *
     * @return $this
     */
    public function put()
    {
        return $this->method(Request::METHOD_PUT);
    }

    /**
     * Set the visiting method to be a DELETE request.
     *
     * @return $this
     */
    public function delete()
    {
        return $this->method(Request::METHOD_DELETE);
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
     * @return array{url:string|null,method:string}|null
     */
    public function urlToArray($parameters = [], $typed = [])
    {
        $url = $this->getUrl($parameters, $typed);

        if (! $url) {
            return null;
        }

        return [
            'url' => $url,
            'method' => $this->getMethod(),
        ];
    }

    /**
     * Determine if the parameters are a route bound.
     *
     * @param  mixed  $parameters
     * @return bool
     */
    protected function implicitRoute($parameters)
    {
        return is_string($parameters) && Str::is('{*}', $parameters);
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
