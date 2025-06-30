<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use function is_string;

trait CanHaveUrl
{
    /**
     * The route to visit.
     *
     * @var string|\Closure(...mixed):string|null
     */
    protected string|Closure|null $url = null;

    /**
     * Set the url to visit.
     *
     * @param  string|(\Closure(...mixed):string)|null  $value
     * @return $this
     */
    public function url(string|Closure|null $value, mixed $parameters = []): static
    {
        $this->url = match (true) {
            ! $value => null,
            $value instanceof Closure => $value,
            $this->implicitRoute($parameters) => fn ($record) => route($value, $record, true),
            Str::startsWith($value, ['http://', 'https://', '/', '#']) => URL::to($value),
            default => route($value, $parameters, true),
        };

        return $this;
    }

    /**
     * Retrieve the route.
     *
     * @param  array<string,mixed>  $named
     * @param  array<class-string,mixed>  $typed
     */
    public function getUrl(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->url, $named, $typed);
    }

    /**
     * Determine if there is a URL set.
     */
    public function hasUrl(): bool
    {
        return isset($this->url);
    }

    /**
     * Determine if the parameters are a route bound.
     */
    protected function implicitRoute(mixed $parameters): bool
    {
        return is_string($parameters) && Str::is('{*}', $parameters);
    }
}
