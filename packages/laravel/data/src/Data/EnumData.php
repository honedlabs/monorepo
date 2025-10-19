<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Honed\Data\Normalizers\EnumNormalizer;
use Spatie\LaravelData\Resource;

class EnumData extends OptionData
{
    /**
     * Return a list of normalizers to use for the data.
     * 
     * @return list<class-string<\Spatie\LaravelData\Normalizers\Normalizer>>
     */
    public static function normalizers(): array
    {
        return [
            EnumNormalizer::class,
        ];
    }
}
