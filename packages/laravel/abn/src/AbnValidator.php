<?php

declare(strict_types=1);

namespace Honed\Abn;

class AbnValidator
{
    /**
     * The weights for the ABN by position.
     *
     * @var array<int, int>
     *
     * @see https://abr.business.gov.au/Help/AbnFormat
     */
    public const WEIGHTS = [10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19];

    /**
     * Format a valid ABN using the spacing format.
     */
    public static function format(?string $abn): ?string
    {
        if (! $abn) {
            return null;
        }

        /** @var string */
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{3})/', '$1 $2 $3 $4', $abn);
    }

    /**
     * Generate a fake ABN.
     */
    public static function fake(bool $valid = false): string
    {
        if (! $valid) {
            return (string) random_int(10000000000, 99999999999);
        }

        $abn = null;

        do {
            $digits = [];

            foreach (range(0, 10) as $i) {
                $digits[] = random_int(0, 9);
            }

            $abn = implode('', $digits);
        } while (static::fails($abn));

        return $abn;
    }

    /**
     * Determine if the given value is not a valid ABN.
     */
    public static function fails(mixed $value): bool
    {
        return ! static::passes($value);
    }

    /**
     * Determine if the given value is a valid ABN.
     */
    public static function passes(mixed $value): bool
    {
        return static::validate($value);
    }

    /**
     * Determine if the given value is a valid ABN.
     */
    public static function validate(mixed $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        /** @var string */
        $abn = preg_replace('/[^0-9]/', '', $value);

        if (static::invalidLength($abn)) {
            return false;
        }

        if (static::leadingZero($abn)) {
            return false;
        }

        $abn[0] = ((int) $abn[0]) - 1;

        return static::checksum($abn) % 89 === 0;
    }

    /**
     * Determine if the given ABN is not the correct length.
     */
    protected static function invalidLength(string $abn): bool
    {
        return mb_strlen($abn) !== 11;
    }

    /**
     * Determine if the ABN contains a leading zero.
     */
    protected static function leadingZero(string $abn): bool
    {
        return (int) $abn[0] === 0;
    }

    /**
     * Determine the checksum of the given ABN.
     */
    protected static function checksum(string $abn): int
    {
        $checksum = 0;

        foreach (mb_str_split($abn) as $index => $digit) {
            $checksum += (int) $digit * static::WEIGHTS[$index];
        }

        return $checksum;
    }
}
