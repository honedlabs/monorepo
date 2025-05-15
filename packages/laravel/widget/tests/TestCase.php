<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\TestCase as Orchestra;
use Orchestra\Testbench\Concerns\WithWorkbench;

#[WithMigration]
class TestCase extends Orchestra
{
    use WithWorkbench;
}
