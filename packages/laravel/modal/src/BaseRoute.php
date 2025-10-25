<?php

declare(strict_types=1);

namespace Honed\Modal;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\Response;

class BaseRoute
{
    public function __construct(
        protected Router $router,
        protected Container $container,
    ) {}

    /**
     * Create a new base route instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Visit the base URL with the given request.
     */
    public static function visit(Request $request, string $baseUrl): Response
    {
        return static::make()->dispatch($request, $baseUrl);
    }

    /**
     * Dispatch the request to the base URL.
     */
    public function dispatch(Request $currentRequest, string $baseUrl): Response
    {
        $nextRequest = $this->copyRequest($currentRequest, $baseUrl);

        $route = $this->router->getRoutes()->match($nextRequest);

        $nextRequest->setRouteResolver(fn () => $route);

        $this->bindRequest($nextRequest);

        /** @var Response */
        return app(Pipeline::class)
            ->send($nextRequest)
            ->through($this->gatherMiddleware($route))
            ->finally(function (Request $request) {
                $this->bindRequest($request);
            })
            ->then(function (Request $request) use ($route) {
                $this->bindRequest($request);

                $response = $route->run();

                if ($response instanceof Responsable) {
                    return $response->toResponse($request);
                }

                return $response;
            });
    }

    /**
     * Create a new request instance at the given URI.
     */
    protected function copyRequest(Request $current, string $uri): Request
    {
        $request = Request::create(
            $uri,
            Request::METHOD_GET,
            $current->query->all(),
            $current->cookies->all(),
            $current->files->all(),
            $current->server->all(),
        );

        $request->headers->replace($current->headers->all());
        $request->setRequestLocale($current->getLocale());
        $request->setDefaultRequestLocale($current->getDefaultLocale());
        $request->setJson($current->json());
        $request->setUserResolver(fn () => $current->getUserResolver());
        $request->setLaravelSession($current->session());

        return $request;
    }

    /**
     * Bind the request to the container and the router.
     */
    protected function bindRequest(Request $request): void
    {
        Facade::clearResolvedInstance('request');

        $this->container->instance('request', $request);

        $this->router->setCurrentRequest($request);
    }

    /**
     * Gather the middleware for the given route, removed the excluded middleware.
     *
     * @return list<mixed>
     */
    protected function gatherMiddleware(Route $route): array
    {
        $excluded = Modal::getExcludedMiddleware();

        return array_values(
            array_filter(
                $this->router->gatherRouteMiddleware($route),
                static function (string|object $middleware) use ($excluded): bool {
                    foreach ($excluded as $exclude) {
                        if ($middleware === $exclude || is_subclass_of($middleware, $exclude)) {
                            return false;
                        }
                    }

                    return true;
                }
            )
        );
    }
}
