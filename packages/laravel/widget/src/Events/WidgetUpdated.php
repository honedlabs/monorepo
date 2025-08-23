<?php

declare(strict_types=1);

namespace Honed\Widget\Events;

use Illuminate\Foundation\Events\Dispatchable;

class WidgetUpdated
{
    use Dispatchable;

    /**
     * Create a new widget updated event.
     */
    public function __construct(
        public string $widget,
        public mixed $scope,
        public mixed $data,
        public ?string $position,
    ) {}
}
