<?php

namespace Honed\Honed\Data;

use Spatie\LaravelData\Data;
use Honed\Honed\Data\Normalizers\ResourcefulNormalizer;

class ResourcefulData extends Data
{
    public function __construct(
        public string $label,
        public int|string|null $value,
    ) {}

    /**
     * Get the normalizers for the data object.
     * 
     * @return array<int, class-string<\Spatie\LaravelData\Normalizers\Normalizer>>
     */
    public static function normalizers(): array
    {
        return [ResourcefulNormalizer::class, ...parent::normalizers()];
    }
}
