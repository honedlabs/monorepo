<?php

declare(strict_types=1);

namespace Honed\Abn;

class AbnValidator
{
    /**
     * The weights for the ABN by position.
     * 
     * @var array<int, int>
     * @see https://abr.business.gov.au/Help/AbnFormat
     */
    const WEIGHTS = [10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19];

    /**
     * Format a valid ABN using the spacing format.
     * 
     * @param  string  $abn
     * @return string
     */
    public static function format($abn)
    {
        return preg_replace('/(\d{1,2})(\d{1,2})(\d{1,2})(\d{1,2})(\d{1,2})(\d{1,2})(\d{1,2})/', '$1 $2 $3 $4 $5 $6 $7', $abn);
    }

    /**
     * Generate a fake ABN.
     * 
     * @param  bool  $valid
     * @return string
     */
    public static function fake($valid = false)
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

            dd($i);

            $abn = implode('', $digits);
        } while (static::fails($abn));

        return $abn;
    }

    /**
     * Determine if the given value is not a valid ABN.
     * 
     * @param  mixed  $value
     * @return bool
     */
    public static function fails($value)
    {
        return ! static::passes($value);
    }

    /**
     * Determine if the given value is a valid ABN.
     * 
     * @param  mixed  $value
     * @return bool
     */
    public static function passes($value)
    {
        return static::validate($value);
    }
    
    /**
     * Determine if the given value is a valid ABN.
     * 
     * @param  mixed  $value
     * @return bool
     */
    public static function validate($value)
    {
        if (! is_string($value)) {
            return false;
        }

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
     * 
     * @param  string  $abn
     * @return bool
     */
    public static function invalidLength($abn)
    {
        return strlen($abn) !== 11;
    }

    /**
     * Determine if the ABN contains a leading zero.
     * 
     * @param  string  $abn
     * @return bool
     */
    public static function leadingZero($abn)
    {
        return (int) $abn[0] === 0;
    }

    /**
     * Determine the checksum of the given ABN.
     * 
     * @param  string  $abn
     * @return int
     */
    public static function checksum($abn)
    {
        $checksum = 0;

        foreach (str_split($abn) as $index => $digit) {
            $checksum += $digit * static::WEIGHTS[$index];
        }

        return $checksum;
    }
}
