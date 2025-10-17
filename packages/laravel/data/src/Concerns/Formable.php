<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data
 */
trait Formable
{
    public function toForm(): array
    {
        return $this->transform();
    }
}
