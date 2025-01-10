<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Contracts\ResolvesClosures;
use Symfony\Component\HttpFoundation\Request;

class Destination extends Primitive implements ResolvesClosures
{
    use Evaluable;

    /**
     * @var string|\Closure
     */
    protected $destination;

    /**
     * @var string
     */
    protected $resolved;

    /**
     * @var mixed
     */
    protected $parameters = [];

    /**
     * @var array<string,mixed>
     */
    protected $typedParameters = [];

    /**
     * @var string
     */
    protected $as = Request::METHOD_GET;

    /**
     * @var bool
     */
    protected $signed = false;

    /**
     * @var bool
     */
    protected $newTab = false;

    /**
     * @var bool
     */
    protected $download = false;

    /**
     * @var int
     */
    protected $duration = 0;

    /**
     * Create a new destination instance.
     * 
     * @param mixed $destination
     */
    public function __construct($destination = null, $as = Request::METHOD_GET)
    {
        $this->to($destination);
        $this->as($as);
    }

    /**
     * Make a new destination instance.
     */
    public static function make($destination = null, $as = Request::METHOD_GET)
    {
        return resolve(static::class, compact('destination', 'as'));
    }

    public function toArray()
    {
        return [
            'href' => $this->destination(),
            'method' => $this->as(),
        ];
    }

    /**
     * Set the destination and parameters to resolve as a closure, or as a Laravel route. 
     * If no destination is provided, the current destination will be returned.
     * 
     * @param string|\Closure|null $destination
     * @param mixed $parameters
     * @return string|\Closure|null|$this The current destination when no destination is provided, or the instance when setting the destination.
     */
    public function to($destination, $parameters = [])
    {

        if (\is_null($destination)) {
            return $this->destination;
        }

        $this->destination = $destination;

        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Determine if the instance has a destination set.
     */
    public function hasDestination(): bool
    {
        return isset($this->destination);
    }

    /**
     * Get or set the HTTP method to use for the destination.
     * 
     * @param string|null $as
     * @return string|null|$this The current HTTP method when no argument is provided, or the instance when setting the HTTP method.
     */
    public function as($as = null)
    {
        if (\is_null($as)) {
            return $this->as;
        }

        $this->as = $as;

        return $this;
    }

    /**
     * Set the HTTP method to a GET request
     * 
     * @return $this
     */
    public function asGet()
    {
        return $this->as(Request::METHOD_GET);
    }

    /**
     * Set the HTTP method to a POST request
     * 
     * @return $this
     */
    public function asPost()
    {
        return $this->as(Request::METHOD_POST);
    }

    /**
     * Set the HTTP method to a PUT request
     * 
     * @return $this
     */
    public function asPut()
    {
        return $this->as(Request::METHOD_PUT);
    }

    /**
     * Set the HTTP method to a PATCH request
     * 
     * @return $this
     */
    public function asPatch()
    {
        return $this->as(Request::METHOD_PATCH);
    }

    /**
     * Set the HTTP method to a DELETE request
     * 
     * @return $this
     */
    public function asDelete()
    {
        return $this->as(Request::METHOD_DELETE);
    }

    /**
     * Set or get the parameters to be used for the destination.
     * 
     * @param mixed $parameters The parameters to set, or null to retrieve the current parameters.
     * @return mixed|$this The current parameters when no argument is provided, or the instance when setting the parameters.
     */
    public function parameters($parameters = null)
    {
        if (\is_null($parameters)) {
            return $this->parameters;
        }

        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set the link to be signed.
     * 
     * @param bool $signed
     * @return $this
     */
    public function signed($signed = true)
    {
        $this->signed = $signed;

        return $this;
    }

    /**
     * Determine if the link is signed.
     */
    public function isSigned(): bool
    {
        return $this->signed;
    }

    /**
     * Set the link to open in a new tab.
     * 
     * @param bool $newTab
     * @return $this
     */
    public function inNewTab($newTab = true)
    {
        $this->newTab = $newTab;

        return $this;
    }

    /**
     * Determine if the link should open in a new tab.
     */
    public function isNewTab(): bool
    {
        return $this->newTab;
    }

    /**
     * Set the link to be downloaded.
     * 
     * @param bool $download
     * @return $this
     */
    public function asDownload($download = true)
    {
        $this->download = $download;
        return $this;
    }

    /**
     * Determine if the link should be downloaded.
     */
    public function isDownload(): bool
    {
        return $this->download;
    }

    /**
     * Get or set the duration of the link.
     * 
     * @param int|null $duration
     * @return int|null|$this The current duration when no argument is provided, or the instance when setting the duration.
     */
    public function duration($duration = null)
    {
        if (\is_null($duration)) {
            return $this->duration;
        }

        $this->duration = $duration;

        return $this;
    }

    /**
     * Set the duration of the link.
     * 
     * @param int $seconds
     * @return $this
     */
    public function temporary($seconds = 120)
    {
        $this->duration = $seconds;

        return $this;
    }

    /**
     * Determine if the destination is a temporary one.
     */
    public function isTemporary(): bool
    {
        return $this->duration > 0;
    }

    public function resolve($named = [], $typed = [])
    {
        return $this->resolved ??= match (true) {
            \is_callable($this->destination) => $this->evaluate($this->destination, $named, $typed),
            
            default => $this->destination,
        };

    }
}