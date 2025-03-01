<?php

declare(strict_types=1);

namespace Illuminate\Http {
    /**
     * @method mixed safe(string $key, mixed $default = null) Get a safe input value from the request
     * @method \Illuminate\Support\Stringable safeString(string $key, ?string $default = null) Get a safe string input value as a Stringable
     * @method int safeInteger(string $key, int $default = 0) Get a safe integer input value
     * @method float safeFloat(string $key, float $default = 0.0) Get a safe float input value
     * @method bool safeBoolean(string $key, bool $default = false) Get a safe boolean input value
     * @method ?\Illuminate\Support\Carbon safeDate(string $key, ?string $format = null, ?string $tz = null) Get a safe date input value
     * @method \Illuminate\Support\Collection safeArray(string $key, mixed $default = null, string $delimiter = ',') Get a safe array input value as a Collection
     * @method mixed safeScoped(string $key, string $scope, mixed $default = null) Get a safe input value from the request with a scope
     */
    class Request {}
}
