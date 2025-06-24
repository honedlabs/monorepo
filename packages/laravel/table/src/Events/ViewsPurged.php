<?php

declare(strict_types=1);

namespace Honed\Table\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ViewsPurged
{
    use Dispatchable;

    /**
     * Create a new views purged event.
     *
     * @param  array<int, string>|null  $tables
     */
    public function __construct(
        public ?array $tables = null,
    ) {}
}
