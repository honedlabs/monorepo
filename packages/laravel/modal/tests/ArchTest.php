<?php

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Modal')
    ->not->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Modal\Concerns')
    ->toBeTraits();