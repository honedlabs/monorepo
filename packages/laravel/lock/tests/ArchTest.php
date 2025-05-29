<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Lock')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Lock\Concerns')
    ->toBeTraits();

arch('facades')
    ->expect('Honed\Lock\Facades')
    ->toExtend('Illuminate\Support\Facades\Facade');
