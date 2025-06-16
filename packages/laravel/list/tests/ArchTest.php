<?php

declare(strict_types=1);

use Illuminate\Console\Command;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Infolist')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Infolist\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Infolist\Contracts')
    ->toBeInterfaces();

arch('commands')
    ->expect('Honed\Infolist\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);
