<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Exceptions\InvalidMethodException;
use Illuminate\Support\Facades\URL;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

use function in_array;
use function mb_strtoupper;

trait HasMethod
{
    /**
     * The method for visiting the URL.
     */
    protected ?string $method = null;

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
     * Set the HTTP verb to be GET.
     *
     * @return $this
     */
    public function get(): static
    {
        return $this->method(Request::METHOD_GET);
    }

    /**
     * Set the HTTP verb to be POST.
     *
     * @return $this
     */
    public function post(): static
    {
        return $this->method(Request::METHOD_POST);
    }

    /**
     * Set the HTTP verb to be PATCH.
     *
     * @return $this
     */
    public function patch(): static
    {
        return $this->method(Request::METHOD_PATCH);
    }

    /**
     * Set the HTTP verb to be PUT.
     *
     * @return $this
     */
    public function put(): static
    {
        return $this->method(Request::METHOD_PUT);
    }

    /**
     * Set the HTTP verb to be DELETE.
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
        return $this->method ?? $this->getFallbackMethod();
    }

    /**
     * Get the fallback method
     */
    protected function getFallbackMethod(): string
    {
        return Request::METHOD_GET;
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
