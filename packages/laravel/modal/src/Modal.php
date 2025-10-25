<?php

declare(strict_types=1);

namespace Honed\Modal;

use BackedEnum;
use Honed\Modal\Support\ModalHeader;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Support\Header;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class Modal implements Responsable
{
    /**
     * The route to display underneath the modal.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Create a modal instance.
     *
     * @param  array<string, mixed>  $props
     */
    public function __construct(
        protected string $component,
        protected array $props = []
    ) {}

    /**
     * Get the excluded middleware to exclude when dispatching the base request.
     * 
     * @return list<class-string>
     */
    public static function getExcludedMiddleware(): array
    {
        /** @var list<class-string> */
        return config('modal.middleware', []);
    }

    /**
     * Get the render callbacks to execute before the base route is rerendered.
     * 
     * @return list<callable(Request, Response): void>
     */
    public static function getRenderCallbacks(): array
    {
        /** @var list<callable(Request, Response): void> */
        return config('modal.renders', []);
    }

    /**
     * Set the base URL for the modal.
     *
     * @return $this
     */
    public function baseUrl(string $url): static
    {
        $this->baseUrl = $url;

        return $this;
    }

    /**
     * Set the base named route for the modal.
     *
     * @return $this
     */
    public function baseRoute(
        string|BackedEnum $name,
        mixed $parameters = [],
        bool $absolute = true
    ): static {

        $this->baseUrl = route($name, $parameters, $absolute);

        return $this;
    }

    /**
     * Get the base URL for the modal.
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Add props to the view.
     *
     * @param  array<string, mixed>|\Illuminate\Contracts\Support\Arrayable<string, mixed>  $props
     * @return $this
     */
    public function props(array|Arrayable $props): static
    {
        $this->props = array_merge($this->props, is_array($props) ? $props : $props->toArray());

        return $this;
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
        
        return match (true) {
            $response instanceof Responsable => $response->toResponse($request),
            $response instanceof JsonResponse => $this->toJsonResponse($response, $this->getModalUrl($request)),
            $response instanceof IlluminateResponse => $this->toViewResponse($request, $response, $this->getModalUrl($request)),
            default => $response,
        };
    }

    /**
     * Render the modal on the base URL.
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable
     */
    public function render()
    {
        $request = $this->getRequest();

        $redirect = $this->getRedirectUrl($request);

        Inertia::share([
            ModalHeader::PROP => [
                'component' => $this->component,
                'baseUrl' => $this->baseUrl,
                'redirectURL' => $redirect,
                'key' => $request->header(ModalHeader::KEY, Str::uuid()->toString()),
                'nonce' => Str::uuid()->toString(),
            ],
        ]);

        if ($request->header(Header::INERTIA) && $request->header(Header::PARTIAL_COMPONENT)) {
            return Inertia::render($request->header(Header::PARTIAL_COMPONENT));
        }

        return BaseRoute::visit($request, $redirect);
    }

    /**
     * Get the URL to display the modal at.
     */
    public function getModalUrl(Request $request): string
    {
        return Str::start(Str::after($request->fullUrl(), $request->getSchemeAndHttpHost()), '/');
    }

    /**
     * Get the URL to redirect to when the modal is exited.
     */
    public function getRedirectUrl(Request $request): string
    {
        if ($request->header(ModalHeader::REDIRECT)) {
            return $request->header(ModalHeader::REDIRECT);
        }

        $referer = $request->headers->get('referer');

        if ($request->header(Header::INERTIA) && $referer && $referer !== url()->current()) {
            return $referer;
        }

        return $this->baseUrl;
    }

    /**
     * Replace the URL in the View Response with the modal's URL to ensure it won't redirect back to the base URL.
     */
    protected function toViewResponse(
        Request $request,
        IlluminateResponse $response,
        string $url
    ): IlluminateResponse {

        $originalContent = $response->getOriginalContent();

        if (! $originalContent instanceof View) {
            return $response;
        }

        $viewData = $originalContent->getData();
        $viewData['page']['url'] = $url;

        foreach (static::getRenderCallbacks() as $callback) {
            $callback($request, $response);
        }

        return ResponseFactory::view($originalContent->getName(), $viewData);
    }

    /**
     * Replace the URL in the JSON response with the modal's URL to ensure it won't redirect back to the base URL.
     */
    protected function toJsonResponse(JsonResponse $response, string $url): JsonResponse
    {
        /** @var array<string, mixed> */
        $data = $response->getData(true);

        return $response->setData([
            ...$data,
            'url' => $url,
        ]);
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
