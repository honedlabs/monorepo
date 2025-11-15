<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

class PendingCommand
{
    public function __construct(
        protected Kernel $kernel
    ) { }

    public function call(ScaffoldContext $context): void
    {
        // $this->kernel->call();
    }
}