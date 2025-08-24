<?php

declare(strict_types=1);

namespace Honed\Widget\Events;

use Honed\Widget\Widget;
use Illuminate\Foundation\Events\Dispatchable;

class WidgetCreated
{
    use Dispatchable;

    /**
     * Create a new widget created event.
     */
    public function __construct(
        public string $widget,
        public string $scope,
        public mixed $data = null,
        public ?string $position = null,
    ) {}
}
