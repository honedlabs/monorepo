<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Inspectable
{
    /**
     * Retrieve a fluent value from a property or method, with an optional default.
     *
     * @throws \Throwable
     */
    public function inspect(string $key, mixed $default = null): mixed
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }

        if (property_exists($this, $key) && isset($this->{$key})) {
            return $this->{$key};
        }

        if ($default instanceof \Throwable) {
            throw $default;
        }

        return value($default);
    }
}
