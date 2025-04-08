<?php

declare(strict_types=1);

namespace Honed\Form;

class Typescript
{
    /**
     * required, nullable, filled, 
     * 
     * alpha, alpha_dash, alpha_num, array, ascii, boolean, current_password
     * date, decimal, declined, email, enum, file, hex_color, image, integer, 
     * ip, ipv4, ipv6, json, list, mac_address, numeric, string,
     * timezone, url, ulid, uuid
     * 
     * 
     * Complex: 
     *     Nested -> need to check the properties -> or enable enforce
     *     confirmed -> needs to match whatever it's sister field type is
     *     exists -> needs to provide a way to inject defaults (unique)
     *     same -> needs to match whatever it's sister field type is
     * 
     * Validation insrances:
     *     - enum, exists
     */
    public static function typeToTypescript($rule)
    {
        return match ($rule) {
            'list',
            'array' => '[]',
            
            'alpha',
            'alpha_dash',
            'alpha_num',
            'ascii',
            'current_password',
            'email',
            'hex_color',
            'ip',
            'ipv4',
            'ipv6',
            'json',
            'mac_address',
            'string',
            'timezone',
            'url',
            'ulid',
            'uuid' => 'string',

            'bool',
            'boolean' => 'boolean',

            'decimal',
            'integer',
            'number' => 'number',

            'image',
            'file' => 'File',

            default => 'unknown',
        };
    }

}