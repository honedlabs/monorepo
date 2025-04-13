<?php

declare(strict_types=1);

namespace Honed\Layout;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\Support\Str;
use Inertia\Response as InertiaResponse;
use Inertia\Support\Header;

class Response extends InertiaResponse
{
    const FORMATTER = '@';

    /**
     * The persistent layouts to use for the response.
     *
     * @var string|null
     */
    protected $layout;

    /**
     * Set the persistent layout(s) for the response.
     *
     * @param  string|\BackedEnum<string>|\UnitEnum  $layout
     * @return $this
     */
    public function layout($layout)
    {
        /** @var string */
        $layout = match (true) {
            $layout instanceof \BackedEnum => $layout->value,
            $layout instanceof \UnitEnum => $layout->name,
            default => $layout,
        };

        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the persistent layout(s) for the response.
     *
     * @return string|null
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

        $page = \array_merge([
            'component' => $this->getLayoutedComponent(),
            'props' => $props,
            'url' => Str::start(Str::after($request->fullUrl(), $request->getSchemeAndHttpHost()), '/'),
            'version' => $this->version,
            'clearHistory' => $this->clearHistory,
            'encryptHistory' => $this->encryptHistory,
        ], $this->resolveMergeProps($request),
            $this->resolveDeferredProps($request),
            $this->resolveCacheDirections($request),
        );

        if ($request->header(Header::INERTIA)) {
            return new JsonResponse($page, 200, [Header::INERTIA => 'true']);
        }

        return ResponseFactory::view($this->rootView, $this->viewData + ['page' => $page]);
    }

    /**
     * Get the component with the layout applied.
     *
     * @return string
     */
    public function getLayoutedComponent()
    {
        if ($layout = $this->getLayout()) {
            return $this->component.self::FORMATTER.$layout;
        }

        return $this->component;
    }

    /**
     * Get the component and the layout from an input.
     *
     * @param  string  $component
     * @return array{string, string|null}
     */
    public static function parseComponent($component)
    {
        $parts = \explode(self::FORMATTER, $component, 2);

        return [$parts[0], $parts[1] ?? null];
    }

    /**
     * {@inheritdoc}
     */
    public function isPartial(Request $request): bool
    {
        return $request->header(Header::PARTIAL_COMPONENT) === $this->getLayoutedComponent();
    }
}
