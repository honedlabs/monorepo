<?php

declare(strict_types=1);

use Honed\Modal\Contracts\RenderCallback;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Modal')
    ->toUseStrictTypes();

arch('callbacks')
    ->expect('Honed\Modal\Callbacks')
    ->toBeClasses()
    ->toImplement(RenderCallback::class);

arch('contracts')
    ->expect('Honed\Modal\Contracts')
    ->toBeInterfaces();
