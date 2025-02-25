<?php

declare(strict_types=1);

namespace Honed\Modal;

use Honed\Modal\Support\ModalHeader;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Support\Header;

class Modal implements Responsable
{
    /**
     * The route to display the modal on if not coming from an Inertia page.
     *
     * @var string
     */
    protected $baseURL;

    /**
     * The props to pass to the modal.
     *
     * @var array<string, mixed>
     */
    protected $props;

    /**
     * Create a modal instance.
     *
     * @param  array<string, mixed>|\Illuminate\Contracts\Support\Arrayable<string, mixed>  $props
     */
    public function __construct(
        protected string $component,
        array|Arrayable $props = []
    ) {
        $this->with($props);
    }

    /**
     * Set the base named route for the modal.
     *
     * @return $this
     */
    public function baseRoute(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        $this->baseURL = route($name, $parameters, $absolute);

        return $this;
    }

    /**
     * Set the base URL for the modal.
     *
     * @return $this
     */
    public function baseURL(string $url): static
    {
        $this->baseURL = $url;

        return $this;
    }

    /**
     * Set the props for the response.
     *
     * @param  array<string, mixed>|Arrayable<string, mixed>  $props
     * @return $this
     */
    public function with(array|Arrayable $props): static
    {
        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        }

        $this->props = $props;

        return $this;
    }

    /**
     * Render the modal on the base URL.
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable
     */
    public function render(): mixed
    {
        Inertia::share(['modal' => $this->component(), ...Arr::dot($this->props, 'modal.props.')]);

        // render background component on first visit
        if (request()->header(Header::INERTIA) && request()->header(Header::PARTIAL_COMPONENT)) {
            return Inertia::render(request()->header(Header::PARTIAL_COMPONENT));
        }

        /** @var Request $incoming */
        $incoming = app('request');

        $request = Request::create(
            $this->redirectURL(),
            Request::METHOD_GET,
            $incoming->query->all(),
            $incoming->cookies->all(),
            $incoming->files->all(),
            $incoming->server->all(),
            $incoming->getContent()
        );

        /** @var \Illuminate\Routing\Router */
        $router = app('router');

        $baseRoute = $router->getRoutes()->match($request);

        $request->headers->replace($incoming->headers->all());

        /** @phpstan-ignore-next-line */
        $request->setJson($incoming->json())
            ->setUserResolver(fn () => $incoming->getUserResolver())
            ->setRouteResolver(fn () => $baseRoute)
            ->setLaravelSession($incoming->session());

        app()->instance('request', $request);

        return $this->handleRoute($request, $baseRoute);
    }

    /**
     * Execute the route action.
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable
     */
    protected function handleRoute(Request $request, Route $route): mixed
    {
        /** @var \Illuminate\Routing\Router */
        $router = app('router');

        $middleware = new SubstituteBindings($router);

        /** @var \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable */
        return $middleware->handle($request, fn () => $route->run());
    }

    /**
     * Retrieve the modal component for serialization..
     *
     * @return array<string, mixed>
     */
    protected function component(): array
    {
        return [
            'component' => $this->component,
            'baseURL' => $this->baseURL,
            'redirectURL' => $this->redirectURL(),
            'key' => request()->header(ModalHeader::KEY, Str::uuid()->toString()),
            'nonce' => Str::uuid()->toString(),
        ];
    }

    /**
     * Get the URL to redirect to when the modal is exited.
     */
    protected function redirectURL(): string
    {
        if (request()->header(ModalHeader::REDIRECT)) {
            return request()->header(ModalHeader::REDIRECT);
        }

        $referer = request()->headers->get('referer');

        if (request()->header(Header::INERTIA) && $referer && $referer !== url()->current()) {
            return $referer;
        }

        return $this->baseURL;
    }

    /**
     * Create an HTTP response that represents the modal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $response = $this->render();

        if ($response instanceof Responsable) {
            return $response->toResponse($request);
        }

        return $response;
    }
}
