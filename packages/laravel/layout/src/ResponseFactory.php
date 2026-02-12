<?php

declare(strict_types=1);

namespace Honed\Layout;

use Illuminate\Contracts\Support\Arrayable;
use Inertia\ProvidesInertiaProperties;
use Inertia\ResponseFactory as InertiaResponseFactory;

class ResponseFactory extends InertiaResponseFactory
{
    /**
     * Render the response.
     *
     * @param  array<array-key, mixed>|Arrayable<array-key, mixed>|ProvidesInertiaProperties  $props
     */
    public function render(string $component, $props = []): Response
    {
        if (config('inertia.ensure_pages_exist', false)) {
            $this->findComponentOrFail($component);
        }

        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        } elseif ($props instanceof ProvidesInertiaProperties) {
            $props = [$props];
        }

        return new Response(
            $component,
            array_merge($this->sharedProps, $props),
            $this->rootView,
            $this->getVersion(),
            (bool) ($this->encryptHistory ?? config('inertia.history.encrypt', false)),
            $this->urlResolver,
        );
    }
}
