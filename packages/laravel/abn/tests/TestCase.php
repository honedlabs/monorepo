<?php

declare(strict_types=1);

namespace Honed\Abn\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

#[WithMigration('laravel')]
class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;
}
