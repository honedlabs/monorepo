<?php

declare(strict_types=1);

namespace Honed\Layout;

use Inertia\ResponseFactory;
use Illuminate\Contracts\Support\Arrayable;

class LayoutResponseFactory extends ResponseFactory
{
    /**
     * @param  array|Arrayable  $props
     */
    public function render(string $component, $props = []): LayoutResponse
    {
        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        }

        return new LayoutResponse(
            $component,
            array_merge($this->sharedProps, $props),
            $this->rootView,
            $this->getVersion(),
            $this->encryptHistory ?? config('inertia.history.encrypt', false),
        );
    }
}