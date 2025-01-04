<?php

declare(strict_types=1);

namespace Honed\Core\Link;

use Carbon\Carbon;
use Honed\Core\Primitive;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

class Link extends Primitive
{
    use Concerns\HasLink {
        getLink as private getDestination;
        resolveLink as private resolveDestination;
    }
    use Concerns\HasLinkDuration;
    use Concerns\HasMethod;
    use Concerns\IsDownloadable;
    use Concerns\IsNewTab;
    use Concerns\IsSigned;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * Create a new parameterised link instance.
     *
     * @param  string|(\Closure(mixed...):string)|null  $link
     */
    final public function __construct(string|\Closure|null $link = null, ?string $method = Request::METHOD_GET)
    {
        parent::__construct();
        $this->setLink($link);
        $this->setMethod($method);
    }

    /**
     * Make a link parameter object.
     *
     * @param  string|(\Closure(mixed...):string)  $link
     * @param  string|(\Closure():string)|null  $method
     */
    public static function make(string|\Closure|null $link = null, string|\Closure|null $method = Request::METHOD_GET): static
    {
        return resolve(static::class, compact('link', 'method'));
    }

    /**
     * Alias for setting a url, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $route
     * @return $this
     */
    public function to($route): static
    {
        $this->setUrl($route);

        return $this;
    }

    /**
     * Set the signed route, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $route
     * @return $this
     */
    public function signedRoute(string|\Closure $route, mixed $parameters = null, int|Carbon $duration = 0): static
    {
        $this->setLink($route);
        $this->setSigned(true);
        $this->setLinkDuration($duration);
        $this->setParameters($parameters);

        return $this;
    }

    /**
     * Retrieve the link, evaluating it if it is a closure.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getLink(array $parameters = [], array $typed = []): ?string
    {
        if (! $this->hasLink()) {
            return null;
        }

        return $this->url ??= match (true) {
            $this->isSigned() && $this->isTemporary() => Url::temporarySignedRoute($this->link, $this->getLinkDuration(), $this->parameters ?? $parameters), // @phpstan-ignore-line
            $this->isSigned() => Url::signedRoute($this->link, $this->parameters ?? $parameters), // @phpstan-ignore-line
            default => $this->getDestination($parameters, $typed),
        };
    }

    public function toArray()
    {
        return [
            'url' => $this->getLink(),
            'method' => $this->getMethod(),
        ];
    }
}
