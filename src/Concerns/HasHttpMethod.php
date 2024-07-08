<?php

namespace Conquest\Core\Concerns;

use Illuminate\Http\Request;

trait HasHttpMethod
{
    protected ?string $method = null;

    public const METHODS = [
        Request::METHOD_GET,
        Request::METHOD_POST,
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE,
        Request::METHOD_HEAD,
        Request::METHOD_OPTIONS,
    ];

    public function method(string $method): static
    {
        $this->setMethod($method);
        return $this;
    }

    public function setMethod(string|null $method): void
    {
        if (is_null($method)) return;

        if (!in_array($method, self::METHODS)) {
            throw new \InvalidArgumentException("Provide HTTP method [$method] is not valid.");
        }
        $this->method = $method;
    }

    public function getMethod(): ?string
    {
        return $this->evaluate($this->method);
    }

    public function hasMethod(): bool
    {
        return !is_null($this->getMethod());
    }

    public function useGet(): static
    {
        return $this->method(Request::METHOD_GET);
    }

    public function usePost(): static
    {
        return $this->method(Request::METHOD_POST);
    }

    public function usePut(): static
    {
        return $this->method(Request::METHOD_PUT);
    }

    public function usePatch(): static
    {
        return $this->method(Request::METHOD_PATCH);
    }

    public function useDelete(): static
    {
        return $this->method(Request::METHOD_DELETE);
    }

    public function useHead(): static
    {
        return $this->method(Request::METHOD_HEAD);
    }

    public function useOptions(): static
    {
        return $this->method(Request::METHOD_OPTIONS);
    }

    public function useMethod(string|null $method): static
    {
        return $this->method($method);
    }

    public function isGet(): bool
    {
        return $this->getMethod() === Request::METHOD_GET;
    }

    public function isPost(): bool
    {
        return $this->getMethod() === Request::METHOD_POST;
    }

    public function isPut(): bool
    {
        return $this->getMethod() === Request::METHOD_PUT;
    }

    public function isPatch(): bool
    {
        return $this->getMethod() === Request::METHOD_PATCH;
    }

    public function isDelete(): bool
    {
        return $this->getMethod() === Request::METHOD_DELETE;
    }

    public function isHead(): bool
    {
        return $this->getMethod() === Request::METHOD_HEAD;
    }

    public function isOptions(): bool
    {
        return $this->getMethod() === Request::METHOD_OPTIONS;
    }
}