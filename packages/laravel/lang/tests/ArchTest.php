<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('documented')
    ->expect('Honed\Lang')
    ->toHaveMethodsDocumented()
    ->toHavePropertiesDocumented();

arch('strict')
    ->expect('Honed\Lang')
    ->toUseStrictTypes()
    ->toUseStrictEquality();

arch('middleware')
    ->expect('Honed\Lang\Middleware')
    ->toBeClasses()
    ->toExtendNothing()
    ->toHaveMethod('handle');

arch('facades')
    ->expect('Honed\Lang\Facades')
    ->toBeClasses()
    ->toExtend(Illuminate\Support\Facades\Facade::class);
