<?php

declare(strict_types=1);

use Honed\Chart\Series;
use Illuminate\Console\Command;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Chart')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Chart\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Chart\Contracts')
    ->toBeInterfaces();

arch('commands')
    ->expect('Honed\Chart\Console\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);

arch('enums')
    ->expect('Honed\Chart\Enums')
    ->toBeEnums();

arch('exceptions')
    ->expect('Honed\Chart\Exceptions')
    ->toExtend(Exception::class);

arch('series')
    ->expect('Honed\Chart\Series')
    ->toExtend(Series::class);
