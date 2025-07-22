<?php

declare(strict_types=1);

namespace Honed\Billing;

use Illuminate\Support\Arr;

class Schema
{
    public static function validate($input): ?string
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
     * Check that the structure is an associative array.
     */
    protected static function checkAssociative(array $input, ?string $key = null): ?string
    {
        if (! is_array($input)) {
            return sprintf(
                'The configuration for key [%s] is not an array.',
                $key ?? 'root'
            );
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
            ?? static::checkPrice($input, $key);
        if ($message = static::checkAssociative($input, $key)) {
            return $message;
        }

        if (!is_string(Arr::get($input, 'type'))) {
            return sprintf(
                'The configuration for key [%s] is not a string.',
                $key
            );
        }

        $out = null ?? 'string';
        

        return null;
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
        return null;
    }

    /**
     * Ensure that a price or group of prices is given.
     * 
     * @param array<string, mixed> $input
     */
    protected static function checkPrice(array $input, string $key): ?string
    {
        return null;
    }
}