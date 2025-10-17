<?php

declare(strict_types=1);

namespace Honed\Data\Normalizers;

use BackedEnum;
use Spatie\LaravelData\Normalizers\Normalized\Normalized;
use Spatie\LaravelData\Normalizers\Normalizer;

class EnumNormalizer implements Normalizer
{
    /**
     * Normalize the value to an array.
     * 
     * @return array{label: string, value: string|int}|null
     */
    public function normalize(mixed $value): null|array|Normalized
    {
        if (! $value instanceof BackedEnum) {
            return null;
        }

        return [
            'label' => $value->name,
            'value' => $value->value,
        ];   
    }
}