<?php

declare(strict_types=1);

use Illuminate\Console\Command;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Abn')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Abn\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Abn\Contracts')
    ->toBeInterfaces();

arch('commands')
    ->expect('Honed\Abn\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);

arch('pipelines')
    ->expect('Honed\Abn\Pipelines')
    ->toBeClasses();
