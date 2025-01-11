<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\EvaluableDependency;
use Honed\Core\Contracts\ResolvesClosures;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends Primitive<string,mixed>
 */
class Destination extends Primitive implements ResolvesClosures
{
    use Evaluable;
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForDestination;
    }

    /**
     * @var string|\Closure|null
     */
    protected $to;

    /**
     * @var string|null
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

    public function __construct(
        string|\Closure|null $to = null,
        mixed $parameters = [],
        string $via = Request::METHOD_GET
    ) {
        $this->to($to, $parameters);
        $this->via($via);
    }

    /**
     * Make a new destination instance.
     */
    public static function make(
        string|\Closure|null $to = null,
        mixed $parameters = [],
        string $via = Request::METHOD_GET
    ): Destination {
        return resolve(static::class, compact('to', 'parameters', 'via'));
    }

    public function toArray()
    {
        return [
            'href' => $this->resolve(),
            'method' => $this->getVia(),
            'tab' => $this->isTab(),
        ];
    }

    /**
     * Set the destination and parameters for this link.
     *
     * @return $this
     */
    public function to(string|\Closure|null $destination = null, mixed $parameters = []): static
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
    public function goesTo()
    {
        return $this->to;
    }

    /**
     * Set the HTTP method to use for the link.
     *
     * @return $this
     */
    public function via(?string $via): static
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
    public function viaGet(): static
    {
        return $this->via(Request::METHOD_GET);
    }

    /**
     * Set the HTTP method to a post request.
     *
     * @return $this
     */
    public function viaPost(): static
    {
        return $this->via(Request::METHOD_POST);
    }

    /**
     * Set the HTTP method to a put request.
     *
     * @return $this
     */
    public function viaPut(): static
    {
        return $this->via(Request::METHOD_PUT);
    }

    /**
     * Set the HTTP method to a patch request.
     *
     * @return $this
     */
    public function viaPatch(): static
    {
        return $this->via(Request::METHOD_PATCH);
    }

    /**
     * Set the HTTP method to a delete request.
     *
     * @return $this
     */
    public function viaDelete(): static
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
     * @return $this
     */
    public function parameters(mixed $parameters = null): static
    {
        if (! \is_null($parameters)) {
            $this->parameters = $parameters;
        }

        return $this;
    }

    /**
     * Get the parameters to be used for the link.
     */
    public function getParameters(): mixed
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
     * @param  mixed  $parameters
     * @param  array<string,mixed>|null  $typed
     */
    public function resolve($parameters = null, $typed = null): ?string
    {
        // @phpstan-ignore-next-line
        return $this->href ??= match (true) {
            \is_null($this->to) => null,
            \is_callable($this->to) => $parameters instanceof \Illuminate\Database\Eloquent\Model
                ? $this->evaluateModelForDestination($parameters, 'resolve')
                : $this->evaluate($this->to, $parameters ?? [], $typed ?? []), // @phpstan-ignore-line
            static::isUri($this->to) => $this->to,
            $this->isSigned() && $this->isTemporary() => URL::temporarySignedRoute($this->to, $this->temporary, $parameters ?? $this->parameters), // @phpstan-ignore-line
            $this->isSigned() => URL::signedRoute($this->to, $parameters ?? $this->parameters),
            default => route($this->to, $parameters ?? $this->parameters),
        };
    }

    /**
     * Determine if the provided value is a valid URI.
     */
    public static function isUri(mixed $uri): bool
    {
        return \is_string($uri)
            && (Str::isUrl($uri) || Str::startsWith($uri, ['/', '#']));
    }
}
