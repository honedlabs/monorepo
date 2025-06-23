<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Honed\Core\Concerns\Transformable;

trait CanFormatValues
{
    use HasPlaceholder;
    use Transformable;

    /**
     * Format the value of the entry.
     *
     * @param  mixed  $value
     * @return mixed
     */
    abstract public function format($value);

    /**
     * Get the formatted value of the entry, and whether a placeholder was used.
     *
     * @param  mixed  $value
     * @return array{mixed, bool}
     */
    public function getFormattedValue($value)
    {
        $value = $this->transform($value);

        return match (true) {
            is_null($value) => [$this->getPlaceholder(), (bool) $this->getPlaceholder()],
            default => [$this->format($value), false],
        };
    }
}