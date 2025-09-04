<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Disable')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Disable\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Disable\Contracts')
    ->toBeInterfaces();
