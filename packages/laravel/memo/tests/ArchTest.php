<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Facade;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Memo')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Memo\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Memo\Contracts')
    ->toBeInterfaces();

arch('facades')
    ->expect('Honed\Memo\Facades')
    ->toBeClasses()
    ->toExtend(Facade::class);
