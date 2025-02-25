<?php

declare(strict_types=1);

namespace Honed\Modal;

use Honed\Modal\Support\ModalHeader;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Inertia\Support\Header;

class Modal implements Responsable
{
    protected string $baseURL;

    /**
     * @param  array<string, mixed>|Arrayable<string, mixed>  $props
     */
    public function __construct(
        protected string $component,
        protected array|Arrayable $props = []
    ) {}

    public function baseRoute(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        $this->baseURL = route($name, $parameters, $absolute);

        return $this;
    }

    public function basePageRoute(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        return $this->baseRoute($name, $parameters, $absolute);
    }

    public function baseURL(string $url): static
    {
        $this->baseURL = $url;

        return $this;
    }

    /**
     * @param  array<string, mixed>|Arrayable<string, mixed>  $props
     */
    public function with(array|Arrayable $props): static
    {
        $this->props = $props;

        return $this;
    }

    public function render(): mixed
    {
        /** @phpstan-ignore-next-line */
        inertia()->share(['modal' => $this->component()]);

        // render background component on first visit
        if (request()->header(Header::INERTIA) && request()->header(Header::PARTIAL_COMPONENT)) {
            /** @phpstan-ignore-next-line */
            return inertia()->render(request()->header(Header::PARTIAL_COMPONENT));
        }

        /** @var Request $originalRequest */
        $originalRequest = app('request');

        $request = Request::create(
            $this->redirectURL(),
            Request::METHOD_GET,
            $originalRequest->query->all(),
            $originalRequest->cookies->all(),
            $originalRequest->files->all(),
            $originalRequest->server->all(),
            $originalRequest->getContent()
        );

        /** @var \Illuminate\Routing\Router */
        $router = app('router');

        $baseRoute = $router->getRoutes()->match($request);

        $request->headers->replace($originalRequest->headers->all());

        /** @phpstan-ignore-next-line */
        $request->setJson($originalRequest->json())
            ->setUserResolver(fn () => $originalRequest->getUserResolver())
            ->setRouteResolver(fn () => $baseRoute)
            ->setLaravelSession($originalRequest->session());

        app()->instance('request', $request);

        return $this->handleRoute($request, $baseRoute);
    }

    protected function handleRoute(Request $request, Route $route): mixed
    {
        /** @var \Illuminate\Routing\Router */
        $router = app('router');

        $middleware = new SubstituteBindings($router);

        return $middleware->handle(
            $request,
            fn () => $route->run()
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function component(): array
    {
        return [
            'component' => $this->component,
            'baseURL' => $this->baseURL,
            'redirectURL' => $this->redirectURL(),
            'props' => $this->props,
            'key' => request()->header(ModalHeader::KEY, Str::uuid()->toString()),
            'nonce' => Str::uuid()->toString(),
        ];
    }

    protected function redirectURL(): string
    {
        if (request()->header(ModalHeader::REDIRECT)) {
            return request()->header(ModalHeader::REDIRECT);
        }

        $referer = request()->headers->get('referer');

        if (request()->header(Header::INERTIA) && $referer && $referer != url()->current()) {
            return $referer;
        }

        return $this->baseURL;
    }

    public function toResponse($request)
    {
        $response = $this->render();

        if ($response instanceof Responsable) {
            return $response->toResponse($request);
        }

        /** @phpstan-ignore-next-line */
        return $response;
    }
}
