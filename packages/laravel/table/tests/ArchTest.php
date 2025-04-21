<?php

declare(strict_types=1);

use Honed\Table\Columns\Column;
use Illuminate\Console\Command;

arch('does not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();