<?php

declare(strict_types=1);

use Spatie\TypeScriptTransformer\Collectors\Collector;
use Spatie\TypeScriptTransformer\Transformers\Transformer;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('src')
    ->toUseStrictTypes();

arch('collectors')
    ->expect('Honed\Typescript\Collectors')
    ->toExtend(Collector::class);

arch('transformers')
    ->expect('Honed\Typescript\Transformers')
    ->toExtend(Transformer::class);
