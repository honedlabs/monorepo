<?php

declare(strict_types=1);

return [
    'adapters' => [
        Honed\Form\Adapters\CustomAdapter::class,
        Honed\Form\Adapters\DateAdapter::class,
        Honed\Form\Adapters\EnumAdapter::class,
        Honed\Form\Adapters\BooleanAdapter::class,
        Honed\Form\Adapters\NumberAdapter::class,
        Honed\Form\Adapters\TextAdapter::class,
        Honed\Form\Adapters\DefaultAdapter::class,
    ],
];
