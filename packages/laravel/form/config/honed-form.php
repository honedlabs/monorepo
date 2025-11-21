<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Adapters
    |--------------------------------------------------------------------------
    |
    | You can specify the global adapters that will be used to attempt to
    | convert data properties and request rules to form components. If the
    | adapter should not be used, you can return null from the adapter's
    | getPropertyComponent or getRulesComponent methods. Adapters are checked
    | in the order they are specified here.
    |
    */

    'adapters' => [
        Honed\Form\Adapters\CustomAdapter::class,
        Honed\Form\Adapters\ArrayAdapter::class,
        Honed\Form\Adapters\DateAdapter::class,
        Honed\Form\Adapters\BooleanAdapter::class,
        Honed\Form\Adapters\NumberAdapter::class,
        Honed\Form\Adapters\ColorAdapter::class,
        Honed\Form\Adapters\TextAdapter::class,
        Honed\Form\Adapters\EnumAdapter::class,
        Honed\Form\Adapters\DefaultAdapter::class,
    ],
];
