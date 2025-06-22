<?php

declare(strict_types=1);

namespace Tests;

use Honed\Widget\WidgetServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Orchestra\Testbench\TestCase as Orchestra;
use Orchestra\Testbench\Concerns\WithWorkbench;

use function Orchestra\Testbench\workbench_path;

class TestCase extends Orchestra
{
    use WithWorkbench;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Inertia::setRootView('app');

        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);

        Carbon::setTestNow(Carbon::now());
    }
}
