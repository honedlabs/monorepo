<?php

declare(strict_types=1);

namespace Honed\Modal;

use Honed\Modal\Concerns\RespondsWithInertia;
use Honed\Modal\Support\ModalHeader;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Support\Header;

class Modal implements Responsable
{
    use RespondsWithInertia;

    /**
     * The modal component to display.
     *
     * @var string
     */
    protected $component;

    /**
     * The props to pass to the modal.
     *
     * @var array<string, mixed>
     */
    protected $props;

    /**
     * The route to display the modal on if not coming from an Inertia page.
     *
     * @var string
     */
    protected $baseURL;

    /**
     * The middleware to exclude from the base route.
     *
     * @var array<int, class-string>
     */
    protected static $excludeMiddleware = [];

    /**
     * Create a modal instance.
     *
     * @param  string  $component
     * @param  array<string, mixed>|\Illuminate\Contracts\Support\Arrayable<string, mixed>  $props
     */
    public function __construct($component, $props = [])
    {
        $this->component = $component;

        $this->newRequest();

        $this->with($props);
    }

    /**
     * Set the props for the response.
     *
     * @param  array<string, mixed>|\Illuminate\Contracts\Support\Arrayable<string, mixed>  $props
     * @return $this
     */
    public function with($props)
    {
        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        }

        $this->props = $props;

        return $this;
    }

    /**
     * Set the base URL for the modal.
     *
     * @param  string  $url
     * @return $this
     */
    public function baseURL($url)
    {
        $this->baseURL = $url;

        return $this;
    }

    /**
     * Set the base named route for the modal.
     *
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return $this
     */
    public function baseRoute($name, $parameters = [], $absolute = true)
    {
        $this->baseURL = route($name, $parameters, $absolute);

        return $this;
    }

    /**
     * Register middleware to exclude when dispatching the base URL request.
     *
     * @param  class-string|iterable<int, class-string>  $middleware
     * @return void
     */
    public static function excludeMiddleware(...$middleware)
    {
        $middleware = Arr::wrap($middleware);

        static::$excludeMiddleware = \array_merge(static::$excludeMiddleware, $middleware);
    }

    /**
     * Render the modal on the base URL.
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable
     */
    public function render()
    {
        Inertia::share([
            'modal' => $this->component(),
            ...Arr::dot($this->props, 'modal.props.'),
        ]);

        if ($this->isPartial()) {
            return Inertia::render($this->getPartial());
        }

        $request = $this->copyRequest($this->getRedirectUrl());

        /** @var \Illuminate\Routing\Router */
        $router = app('router');

        $baseRoute = $router->getRoutes()->match($request);

        $request->headers->replace($this->request->headers->all());

        /** @phpstan-ignore-next-line */
        $request->setJson($this->request->json())
            ->setUserResolver(fn () => $this->request->getUserResolver())
            ->setRouteResolver(fn () => $baseRoute)
            ->setLaravelSession($this->request->session());

        App::instance('request', $request);

        return $this->handleRoute($request, $baseRoute);
    }

    /**
     * Determine if the current request is an Inertia request.
     *
     * @return bool
     */
    public function isInertiaRequest()
    {
        return (bool) $this->request->header(Header::INERTIA);
    }

    /**
     * Get the partial component from the request.
     *
     * @return string|null
     */
    public function getRequestPartialComponent()
    {
        /** @var string|null */
        return $this->request->header(Header::PARTIAL_COMPONENT);
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
            'redirectURL' => $this->getRedirectUrl(),
            'key' => request()->header(ModalHeader::KEY, Str::uuid()->toString()),
            'nonce' => Str::uuid()->toString(),
        ];
    }

    /**
     * Get the URL to redirect to when the modal is exited.
     */
    public function getRedirectUrl(): string
    {
        return request()->header(ModalHeader::REDIRECT)
            ?? $this->getInertiaReferer(request())
            ?? $this->getBaseUrl();
    }

    /**
     * Get the base URL for the modal.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseURL;
    }

    /**
     * Get the referer URL from the request if it is a valid Inertia request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function getInertiaReferer($request)
    {
        $referer = $request->headers->get('referer');

        if ($request->header(Header::INERTIA) 
                && $referer
                && $referer !== url()->current()
        ) {
            return $referer;
        }

        return null;
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
