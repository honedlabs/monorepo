<?php

declare(strict_types=1);

namespace Honed\Layout;

use Inertia\ResponseFactory as InertiaResponseFactory;
use Illuminate\Contracts\Support\Arrayable;

class ResponseFactory extends InertiaResponseFactory
{
    /**
     * @param  array|Arrayable  $props
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