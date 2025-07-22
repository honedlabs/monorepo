<?php

declare(strict_types=1);

namespace Honed\Billing;

use Illuminate\Support\Arr;

class Schema
{
    /**
     * Validate that the schema conforms to the expected structure.
     */
    public static function validate(mixed $input): ?string
    {
        if ($message = static::checkAssociative($input)) {
            return $message;
        }

        if ($message = static::checkUniqueness($input)) {
            return $message;
        }

        foreach ($input as $key => $value) {
            if ($message = static::checkStructure($value, $key)) {
                return $message;
            }
        }

        return null;
    }

    /**
     * Check that the structure is an array.
     */
    protected static function checkArray(mixed $input, ?string $key = null): ?string
    {
        if (! is_array($input)) {
            return sprintf(
                'The configuration for key [%s] is not an array.',
                $key ?? 'root'
            );
        }

        return null;
    }

    /**
     * Check that the structure is an associative array.
     */
    protected static function checkAssociative(mixed $input, ?string $key = null): ?string
    {
        if ($message = static::checkArray($input, $key)) {
            return $message;
        }

        if (! Arr::isAssoc($input)) {
            return sprintf(
                'The configuration for key [%s] is not an associative array.',
                $key ?? 'root'
            );
        }

        return null;
    }

    /**
     * Check that the structure is a list array.
     */
    protected static function checkList(mixed $input, ?string $key = null): ?string
    {
        if ($message = static::checkArray($input, $key)) {
            return $message;
        }

        if (! Arr::isList($input)) {
            return sprintf(
                'The configuration for key [%s] is not a list array.',
                $key ?? 'root'
            );
        }

        return null;
    }

    /**
     * Check if the provided input contains duplicated keys.
     * 
     * @param array<string|int, mixed> $input
     */
    protected static function checkUniqueness(array $input): ?string
    {
        $duplicates = collect($input)
            ->keys()
            ->duplicates()
            ->values();

        if ($duplicates->isEmpty()) {
            return null;
        }

        return sprintf(
            'The configuration contains duplicated keys: [%s]. All keys must be unique.',
            $duplicates->implode(', ')
        );
    }

    /**
     * Check the structure of the provided input.
     */
    protected static function checkStructure(mixed $input, string $key): ?string
    {
        return static::checkAssociative($input, $key)
            ?? static::checkName($input, $key)
            ?? static::checkGroup($input, $key)
            ?? static::checkType($input, $key)
            ?? static::checkPricing($input, $key);
    }

    /**
     * Ensure that a name is given for the product.
     * 
     * @param array<string, mixed> $input
     */
    protected static function checkName(array $input, string $key): ?string
    {
        if (! is_string(Arr::get($input, 'name'))) {
            return sprintf(
                'The name supplied for key [%s] is invalid, it must be a string.',
                $key
            );
        }

        return null;
    }

    /**
     * Ensure that a group, if given, is valid.
     * 
     * @param array<string, mixed> $input
     */
    protected static function checkGroup(array $input, string $key): ?string
    {
        $input = Arr::get($input, 'group');

        if ($input && ! is_string($input)) {
            return sprintf(
                'The group supplied for key [%s] is invalid, it must be a string or none given.',
                $key
            );
        }

        return null;
    }

    /**
     * Ensure that a type, if given, is valid.
     * 
     * @param array<string, mixed> $input
     */
    protected static function checkType(array $input, string $key): ?string
    {
        $input = Arr::get($input, 'type');

        if (! in_array($input, [null, 'null', 'recurring', 'once'])) {
            return sprintf(
                'The type supplied for key [%s] is invalid, it must be one of: null, recurring, once - [%s] given.',
                $key,
                $input
            );
        }

        return null;
    }

    /**
     * Ensure that a price or group of prices is given.
     * 
     * @param array<string, mixed> $input
     */
    protected static function checkPricing(array $input, string $key): ?string
    {        
        if (Arr::hasAll($input, ['price', 'period', 'price_id'])) {
            return static::checkPrice($input, $key);
        }


        if ($prices = Arr::get($input, 'prices', [])) {
            if ($message = static::checkList($prices, $key)) {
                return $message;
            }

            foreach ($prices as $price) {
                if ($message = static::checkPrice($price, $key)) {
                    return $message;
                }
            }

            return null;
        }

        return sprintf(
            'No pricing information found for key [%s].',
            $key
        );
    }

    /**
     * Ensure that a price or group of prices is given.
     * 
     * @param array<string, mixed> $input
     */
    protected static function checkPrice(array $input, string $key): ?string
    {
        return static::checkPeriod($input, $key)
            ?? static::checkPriceId($input, $key)
            ?? static::checkPriceAmount($input, $key);
    }

    /**
     * Ensure that the given period is valid.
     */
    protected static function checkPeriod(array $input, string $key): ?string
    {
        $input = Arr::get($input, 'period');

        if ($input && ! in_array($input, [null, 'null', 'monthly', 'yearly'])) {
            return sprintf(
                'The period supplied for key [%s] is invalid, it must be one of: null, monthly, yearly - [%s] given.',
                $key,
                $input
            );
        }

        return null;
    }

    /**
     * Ensure that the price id is given.
     */
    protected static function checkPriceId(array $input, string $key): ?string
    {
        $input = Arr::get($input, 'price_id');

        if (! is_string($input)) {
            return sprintf(
                'The price id supplied for key [%s] is invalid, it must be a string or null - [%s] given.',
                $key,
                $input
            );
        }

        return null;
    }

    /**
     * Ensure that the price amount is given.
     */
    protected static function checkPriceAmount(array $input, string $key): ?string
    {
        $input = Arr::get($input, 'price');

        if ($input && ! is_numeric($input)) {
            return sprintf(
                'The price supplied for key [%s] is invalid, it must be a number or none given.',
                $key
            );
        }

        return null;
    }
}