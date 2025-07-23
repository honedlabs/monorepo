<?php

declare(strict_types=1);

use Illuminate\Console\Command;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Billing')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Billing\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Billing\Contracts')
    ->toBeInterfaces();

arch('commands')
    ->expect('Honed\Billing\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);
