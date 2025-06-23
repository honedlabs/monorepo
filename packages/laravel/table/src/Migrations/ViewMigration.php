<?php

declare(strict_types=1);

namespace Honed\Table\Migrations;

use Illuminate\Database\Migrations\Migration;
use Honed\Table\Concerns\InteractsWithDatabase;

abstract class ViewMigration extends Migration
{
    use InteractsWithDatabase;
}
