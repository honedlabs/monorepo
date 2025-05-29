<?php

declare(strict_types=1);

namespace Honed\Layout;

use Illuminate\Contracts\Support\Arrayable;
use Inertia\ResponseFactory as InertiaResponseFactory;

class ResponseFactory extends InertiaResponseFactory
{
    /**
     * Render the response.
     *
     * @param  array<string,mixed>|Arrayable<string,mixed>  $props
     */
    public function render(string $component, $props = []): Response
    {
        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        }

        return new Response(
            $component,
            array_merge($this->sharedProps, $props),
            $this->rootView,
            $this->getVersion(),
            $this->encryptHistory ?? config('inertia.history.encrypt', false),
        );
    }
}
