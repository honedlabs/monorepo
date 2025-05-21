<?php

use Illuminate\Console\Command;

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('attributes')
    ->expect('Honed\Registry\Attributes')
    ->toBeClasses();

arch('commands')
    ->expect('Honed\Registry\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);

arch('concerns')
    ->expect('Honed\Registry\Concerns')
    ->toBeTraits();

arch('enums')
    ->expect('Honed\Registry\Enums')
    ->toBeEnums();
