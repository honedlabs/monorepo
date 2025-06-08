<?php

declare(strict_types=1);

namespace Honed\Typescript\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;
}
