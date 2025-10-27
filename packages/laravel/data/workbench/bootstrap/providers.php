<?php

declare(strict_types=1);

return [
    App\Providers\WorkbenchServiceProvider::class,
    Honed\Data\DataServiceProvider::class,
    Spatie\LaravelData\LaravelDataServiceProvider::class,
    Intervention\Validation\Laravel\ValidationServiceProvider::class,
    Propaganistas\LaravelPhone\PhoneServiceProvider::class,
];
