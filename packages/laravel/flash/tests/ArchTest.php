<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Flash')
    ->toUseStrictTypes();

arch('attributes')
    ->expect('Honed\Flash\Attributes')
    ->toBeClasses();

arch('concerns')
    ->expect('Honed\Flash\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Flash\Contracts')
    ->toBeInterfaces();
