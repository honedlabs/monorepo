<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Option')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Option\Concerns')
    ->toBeTraits();
