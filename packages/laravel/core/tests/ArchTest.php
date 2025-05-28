<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Core')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Core\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Core\Contracts')
    ->toBeInterfaces();

arch('exceptions')
    ->expect('Honed\Core\Exceptions')
    ->toExtend(Exception::class);
