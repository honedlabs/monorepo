<?php

declare(strict_types=1);

namespace Honed\Modal;

use BackedEnum;
use Honed\Modal\Support\ModalHeader;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Support\Header;

class Modal implements Responsable
{
    /**
     * The route to display underneath the modal.
     *
     * @var ?string
     */
    protected $baseURL;

    /**
     * The middleware to exclude from the base route.
     *
     * @var list<class-string>
     */
    protected static $excludeMiddleware = [];

    /**
     * Calls to be executed before the base route is rerendered.
     * 
     * @var list<callable(): void>
     */
    protected static $callbacks = [];

    /**
     * Create a modal instance.
     *
     * @param  array<string, mixed>|\Illuminate\Contracts\Support\Arrayable<string, mixed>  $props
     */
    public function __construct(
        protected string $component,
        protected array|Arrayable $props = []
    ) {}

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
     * Get the excluded middleware to exclude when dispatching the base request.
     * 
     * @return array<int, class-string>
     */
    public static function getExcludedMiddleware()
    {
        return array_merge(config('modal.middleware'), static::$excludeMiddleware);
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
     * Set the base named route for the modal.
     *
     * @return $this
     */
    public function baseRoute(
        string|BackedEnum $name,
        array $parameters = [],
        bool $absolute = true
    ): static {

        $this->baseURL = route($name, $parameters, $absolute);

        return $this;
    }

    /**
     * Get the base URL for the modal.
     */
    public function getBaseUrl(): string
    {
        return $this->baseURL;
    }

    /**
     * Add props to the view.
     *
     * @param  string|array<string, mixed>  $key
     * @return $this
     */
    public function with(string|array $key, mixed $value = null): static
    {
        if (is_array($key)) {
            $this->props = array_merge($this->props, $key);
        } else {
            $this->props[$key] = $value;
        }

        return $this;
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

    /**
     * Render the modal on the base URL.
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable
     */
    public function render()
    {
        $this->shareModal();

        $request = $this->getRequest();

        if ($request->header(Header::INERTIA) && $request->header(Header::PARTIAL_COMPONENT)) {
            return Inertia::render($request->header(Header::PARTIAL_COMPONENT));
        }

        $nextRequest = Request::create(
            $this->getRedirectUrl(),
            Request::METHOD_GET,
            $request->query->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->getContent()
        );

        /** @var \Illuminate\Routing\Router */
        $router = app('router');

        $baseRoute = $router->getRoutes()->match($request);

        $nextRequest->headers->replace($request->headers->all());

        /** @phpstan-ignore-next-line */
        $nextRequest->setJson($request->json())
            ->setUserResolver(fn () => $request->getUserResolver())
            ->setRouteResolver(fn () => $baseRoute)
            ->setLaravelSession($request->session());

        App::instance('request', $nextRequest);

        return $this->handleRoute($nextRequest, $baseRoute);
    }

    protected function handleRoute(Request $request, Route $route): mixed
    {
        $router = $this->getRouter();

        $middleware = new SubstituteBindings($router);

        return $middleware->handle(
            $request,
            fn () => $route->run()
        );
    }

    /**
     * Share the modal data via Inertia.
     */
    protected function shareModal(): void
    {
        Inertia::share([
            ModalHeader::PROP => [
                'component' => $this->component,
                'baseURL' => $this->baseURL,
                'redirectURL' => $this->getRedirectUrl(),
                'key' => $this->getRequest()->header(ModalHeader::KEY, Str::uuid()->toString()),
                'nonce' => Str::uuid()->toString(),
            ],
            ...Arr::dot($this->props, ModalHeader::PROP.'.props.'),
        ]);
    }

    /**
     * Get the URL to redirect to when the modal is exited.
     */
    protected function getRedirectUrl(): string
    {
        $request = $this->getRequest();

        if ($request->header(ModalHeader::REDIRECT)) {
            return $request->header(ModalHeader::REDIRECT);
        }

        $referer = $request->headers->get('referer');

        if ($request->header(Header::INERTIA) && $referer && $referer !== url()->current()) {
            return $referer;
        }

        return $this->baseURL;
    }

    /**
     * Get the current request instance.
     */
    protected function getRequest(): Request
    {
        /** @var \Illuminate\Http\Request */
        return app('request');
    }

    /**
     * Get the router.
     */
    protected function getRouter(): Router
    {
        /** @var \Illuminate\Routing\Router */
        return app('router');
    }
}
