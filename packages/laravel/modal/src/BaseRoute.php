<?php

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
    public static function make()
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

        return app(Pipeline::class)
            ->send($nextRequest)
            ->through($this->gatherMiddleware($route))
            ->then(function (Request $request) use ($route) {
                $this->bindRequest($request);

                $response = $route->run();

                if ($response instanceof Responsable) {
                    return $response->toResponse($request);
                }

                return $response;
            })
            ->finally(function (Request $request) {
                $this->bindRequest($request);
            });
    }

    /**
     * Create a new request instance at the given URI.
     */
    protected function copyRequest(Request $request, string $uri): Request
    {
        $new = Request::create(
            $uri,
            Request::METHOD_GET,
            $request->query->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
        );

        $new->headers->replace($request->headers->all());
        $new->setRequestLocale($request->getLocale());
        $new->setDefaultRequestLocale($request->getDefaultLocale());

        return $new;
    }

    /**
     * Bind the request to the container and the router.
     */
    protected function bindRequest(Request $request): void
    {
        Facade::clearResolvedInstance('request');

        $this->container->instance('request', $request);

        // @phpstan-ignore-next-line
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
                static function (mixed $middleware) use ($excluded): bool {
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
