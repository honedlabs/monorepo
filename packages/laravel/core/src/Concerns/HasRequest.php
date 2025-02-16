<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;

trait HasRequest
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Set the request on the instance.
     *
     * @return $this
     */
    public function request(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request on the instance.
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Attempt to resolve the named closure dependencies using the current request.
     *
     * @return array<int, mixed>
     */
    public function resolveRequestClosureDependencyForEvaluationByName(string $parameterName): array
    {
        $request = $this->getRequest();

        $parameters = Arr::mapWithKeys(
            $request->route()?->parameters() ?? [],
            static::getNamedRequestParameters(...)
        );

        /** @var array<int, mixed> */
        return match ($parameterName) {
            'request' => [$request],
            'route' => [$request->route()],
            default => Arr::get($parameters, $parameterName, []),
        };
    }

    /**
     * Attempt to resolve the typed closure dependencies using the current request.
     *
     * @return array<int, mixed>
     */
    public function resolveRequestClosureDependencyForEvaluationByType(string $parameterType): array
    {
        $request = $this->getRequest();

        $parameters = Arr::mapWithKeys(
            $request->route()?->parameters() ?? [],
            static::getTypedRequestParameters(...)
        );

        if (\is_subclass_of($parameterType, User::class)) {
            return [$request->user()];
        }

        return match ($parameterType) {
            Request::class => [$request],
            Route::class => [$request->route()],
            default => Arr::get($parameters, $parameterType, []),
        };
    }

    /**
     * Retrieve the request named parameters.
     *
     * @return array<int, mixed>
     */
    protected static function getNamedRequestParameters(mixed $value, string $key): array
    {
        return [$key => [$value]];
    }

    /**
     * Retrieve the classes for evaluation by type.
     *
     * @return array<class-string, array<int, mixed>>
     */
    protected static function getTypedRequestParameters(mixed $value): array
    {
        return \is_object($value) ? [\get_class($value) => [$value]] : [];
    }
}
