<?php

namespace Honed\Widget\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class WidgetCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'widget:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache the widgets for the application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}