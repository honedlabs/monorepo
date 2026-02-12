<?php

declare(strict_types=1);

namespace Honed\Layout;

use BackedEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Inertia\Response as InertiaResponse;
use Inertia\Support\Header;
use UnitEnum;

class Response extends InertiaResponse
{
    public const FORMATTER = '@';

    /**
     * The persistent layouts to use for the response.
     *
     * @var string|null
     */
    protected $layout;

    /**
     * Get the component and the layout from an input.
     *
     * @return array{string, string|null}
     */
    public static function parseComponent(string $component): array
    {
        $parts = explode(self::FORMATTER, $component, 2);

        return [$parts[0], $parts[1] ?? null];
    }

    /**
     * Set the persistent layout(s) for the response.
     *
     * @return $this
     */
    public function layout(string|BackedEnum|UnitEnum|null $layout): static
    {
        $this->layout = match (true) {
            $layout instanceof BackedEnum => (string) $layout->value,
            $layout instanceof UnitEnum => $layout->name,
            default => $layout,
        };

        return $this;
    }

    /**
     * Get the persistent layout(s) for the response.
     */
    public function getLayout(): ?string
    {
        return $this->layout;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $props = $this->resolveProperties($request, $this->props);

        $page = [
            'component' => $this->getLayoutedComponent(),
            'props' => $props,
            'url' => $this->getUrl($request),
            'version' => $this->version,
            'clearHistory' => $this->clearHistory,
            'encryptHistory' => $this->encryptHistory,
            ...$this->resolveMergeProps($request),
            ...$this->resolveDeferredProps($request),
            ...$this->resolveCacheDirections($request),
            ...$this->resolveScrollProps($request),
            ...$this->resolveOnceProps($request),
            ...$this->resolveFlashData($request),
        ];

        if ($request->header(Header::INERTIA)) {
            return new JsonResponse($page, 200, [Header::INERTIA => 'true']);
        }

        return ResponseFactory::view($this->rootView, $this->viewData + ['page' => $page]);
    }

    /**
     * Get the component with the layout applied.
     */
    public function getLayoutedComponent(): string
    {
        if ($layout = $this->getLayout()) {
            return $this->component.self::FORMATTER.$layout;
        }

        /** @var string */
        return $this->component;
    }

    /**
     * Determine if the response is a partial response.
     */
    public function isPartial(Request $request): bool
    {
        return $request->header(Header::PARTIAL_COMPONENT) === $this->getLayoutedComponent();
    }
}
