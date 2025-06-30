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

trait CanHaveUrl
{
    /**
     * The route to visit.
     *
     * @var string|\Closure(...mixed):string|null
     */
    protected string|Closure|null $url = null;

    /**
     * The method for visiting the URL.
     */
    protected string $method = Request::METHOD_GET;

    /**
     * The target for the URL
     */
    protected ?string $target = null;

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
            Str::startsWith($value, ['http://', 'https://', '/']) => URL::to($value),
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
     * Set the HTTP method for the route.
     *
     * @return $this
     *
     * @throws InvalidMethodException
     */
    public function method(?string $method): static
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
    public function post(): static
    {
        return $this->method(Request::METHOD_POST);
    }

    /**
     * Set the visiting method to be a PATCH request.
     *
     * @return $this
     */
    public function patch(): static
    {
        return $this->method(Request::METHOD_PATCH);
    }

    /**
     * Set the visiting method to be a PUT request.
     *
     * @return $this
     */
    public function put(): static
    {
        return $this->method(Request::METHOD_PUT);
    }

    /**
     * Set the visiting method to be a DELETE request.
     *
     * @return $this
     */
    public function delete(): static
    {
        return $this->method(Request::METHOD_DELETE);
    }

    /**
     * Get the HTTP method for the route.
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the target for the URL.
     *
     * @return $this
     */
    public function target(?string $target): static
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Open the URL in a new tab.
     *
     * @return $this
     */
    public function openUrlInNewTab(): static
    {
        return $this->target('_blank');
    }

    /**
     * Get the target for the URL.
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }

    /**
     * Get the array representation of the route.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array{href:string|null,method:string,target:string|null}
     */
    public function urlToArray(array $parameters = [], array $typed = []): array
    {
        $url = $this->getUrl($parameters, $typed);

        if (! $url) {
            return [];
        }

        return [
            'href' => $url,
            'method' => $this->getMethod(),
            'target' => $this->getTarget(),
        ];
    }

    /**
     * Determine if the parameters are a route bound.
     */
    protected function implicitRoute(mixed $parameters): bool
    {
        return is_string($parameters) && Str::is('{*}', $parameters);
    }

    /**
     * Determine if the HTTP method is invalid.
     */
    protected function invalidMethod(string $method): bool
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
