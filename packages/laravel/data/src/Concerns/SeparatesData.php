<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data
 * @phpstan-require-implements \Honed\Data\Contracts\Separable
 */
trait SeparatesData
{
    public function for(string $key): array
    {
        $keys = $this->getSeparator($key);

        return [];
    }

    /**
     * @return list<string>
     */
    public function getSeparator(string $key): array
    {
        return [];
    }

}