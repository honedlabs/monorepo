<?php

declare(strict_types=1);

namespace Honed\Core;

use Illuminate\Support\Str;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Contracts\ResolvesClosures;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

class Destination extends Primitive implements ResolvesClosures
{
    use Evaluable;

    /**
     * @var string|\Closure
     */
    protected $to;

    /**
     * @var string
     */
    protected $href;

    /**
     * @var mixed
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $via = Request::METHOD_GET;

    /**
     * @var bool
     */
    protected $signed = false;

    /**
     * @var bool
     */
    protected $tab = false;

    /**
     * @var int
     */
    protected $temporary = 0;

    /**
     * Create a new destination instance.
     * 
     * @param mixed $to
     * @param mixed $parameters
     */
    public function __construct($to = null, $parameters = [], string $via = Request::METHOD_GET)
    {
        $this->to($to, $parameters);
        $this->via($via);
    }

    /**
     * Make a new destination instance.
     * 
     * @param mixed $to
     * @param mixed $parameters
     */
    public static function make($to = null, $parameters = [], string $via = Request::METHOD_GET): Destination
    {
        return resolve(static::class, compact('to', 'parameters', 'via'));
    }

    public function toArray()
    {
        return [
            'href' => $this->resolve(),
            'method' => $this->getVia(),
            'tab' => $this->isTab()
        ];
    }

    /**
     * Set the destination and parameters for this link.
     * 
     * @param string|\Closure|null $destination
     * @param mixed $parameters
     * @return $this
     */
    public function to($destination = null, $parameters = []): static
    {

        if (! \is_null($destination)) {
            $this->to = $destination;
            $this->parameters = $parameters;
        }

        return $this;
    }

    /**
     * Get the destination to be used for the link.
     * 
     * @return string|\Closure|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set the HTTP method to use for the link.
     * 
     * @param string|null $via
     * @return $this
     */
    public function via($via = Request::METHOD_GET): static
    {
        if (! \is_null($via)) {
            $this->via = $via;
        }

        return $this;
    }

    /**
     * Set the HTTP method to a get request.
     * 
     * @return $this
     */
    public function viaGet()
    {
        return $this->via(Request::METHOD_GET);
    }

    /**
     * Set the HTTP method to a post request.
     * 
     * @return $this
     */
    public function viaPost()
    {
        return $this->via(Request::METHOD_POST);
    }

    /**
     * Set the HTTP method to a put request.
     * 
     * @return $this
     */
    public function viaPut()
    {
        return $this->via(Request::METHOD_PUT);
    }

    /**
     * Set the HTTP method to a patch request.
     * 
     * @return $this
     */
    public function viaPatch()
    {
        return $this->via(Request::METHOD_PATCH);
    }

    /**
     * Set the HTTP method to a delete request.
     * 
     * @return $this
     */
    public function viaDelete()
    {
        return $this->via(Request::METHOD_DELETE);
    }

    /**
     * Get the HTTP method to use for the link.
     */
    public function getVia(): string
    {
        return $this->via;
    }

    /**
     * Set the parameters to be used for the link.
     * 
     * @param mixed $parameters
     * @return $this
     */
    public function parameters($parameters = null): static
    {
        if (! \is_null($parameters)) {
            $this->parameters = $parameters;
        }

        return $this;
    }

    /**
     * Get the parameters to be used for the link.
     * 
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set the link to be signed.
     * 
     * @return $this
     */
    public function signed(bool $signed = true): static
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
     * @return $this
     */
    public function tab(bool $tab = true): static
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Determine if the link should open in a new tab.
     */
    public function isTab(): bool
    {
        return $this->tab;
    }

    /**
     * Set the duration of the link.
     * 
     * @return $this
     */
    public function temporary(int $seconds = 120): static
    {
        $this->temporary = $seconds;

        return $this;
    }

    /**
     * Determine if the destination is a temporary one.
     */
    public function isTemporary(): bool
    {
        return $this->temporary > 0;
    }

    /**
     * Resolve the destination url using the provided parameters at call-time or from the instance.
     * 
     * @param mixed $parameters
     * @param array<string,mixed>|null $typed
     */
    public function resolve($parameters = null, $typed = null): ?string
    {
        return $this->href ??= match (true) {
            \is_null($this->to) => null,
            \is_callable($this->to) => $this->evaluate($this->to, $parameters, $typed),
            \is_string($this->to) && (Str::isUrl($this->to) || Str::startsWith($this->to, ['/', '#'])) => $this->to,
            $this->isSigned() && $this->isTemporary() => URL::temporarySignedRoute($this->to, $this->temporary, $parameters ?? $this->parameters),
            $this->isSigned() => URL::signedRoute($this->to, $parameters ?? $this->parameters),
            default => route($this->to, $parameters ?? $this->parameters),
        };
    }
}