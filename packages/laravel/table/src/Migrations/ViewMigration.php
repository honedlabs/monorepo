<?php

declare(strict_types=1);

namespace Honed\Table\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

abstract class ViewMigration extends Migration
{
    use InteractsWithDatabase;
}
