<?php

namespace Honed\Crumb\Commands;

use Illuminate\Console\Command;

class CrumbCommand extends Command
{
    public $signature = 'crumb';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
