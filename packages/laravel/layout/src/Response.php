<?php

declare(strict_types=1);

namespace Honed\Layout;

use Honed\Layout\Support\Parameters;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\Support\Str;
use Inertia\Response as InertiaResponse;
use Inertia\Support\Header;

class Response extends InertiaResponse
{
    /**
     * The persistent layouts to use for the response.
     *
     * @var string|array<int,string>|null
     */
    protected $layout;

    /**
     * Set the persistent layout(s) for the response.
     *
     * @param  string|array<int,string>  $layout
     * @return $this
     */
    public function layout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the persistent layout(s) for the response.
     *
     * @return string|array<int,string>|null
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $props = $this->resolveProperties($request, $this->props);

        $page = array_merge(
            [
                'component' => $this->component,
                Parameters::PROP => $this->getLayout(),
                'props' => $props,
                'url' => Str::start(Str::after($request->fullUrl(), $request->getSchemeAndHttpHost()), '/'),
                'version' => $this->version,
                'clearHistory' => $this->clearHistory,
                'encryptHistory' => $this->encryptHistory,
            ],
            $this->resolveMergeProps($request),
            $this->resolveDeferredProps($request),
            $this->resolveCacheDirections($request),
        );

        if ($request->header(Header::INERTIA)) {
            return new JsonResponse($page, 200, [Header::INERTIA => 'true']);
        }

        return ResponseFactory::view($this->rootView, $this->viewData + ['page' => $page]);
    }
}
