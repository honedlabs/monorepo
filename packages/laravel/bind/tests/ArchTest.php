<?php

declare(strict_types=1);

use Illuminate\Console\Command;

// arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Binding')
    ->toUseStrictTypes();

arch('commands')
    ->expect('Honed\Bind\Commands')
    ->toExtend(Command::class);

arch('concerns')
    ->expect('Honed\Binding\Concerns')
    ->toBeTraits();
