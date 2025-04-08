<?php

declare(strict_types=1);

namespace Honed\Form;

class FormValue
{
    /**
     * required, nullable, filled, 
     * 
     * alpha, alpha_dash, alpha_num, array, ascii, boolean, current_password
     * date, decimal, declined, email, enum, file, hex_color, image, integer, 
     * ip, ipv4, ipv6, json, lowercase, list, mac_address,
     * 
     * Complex: 
     *     confirmed -> needs to match whatever it's sister field type is
     *     exists -> needs to provide a way to inject defaults
     * 
     * Validation insrances:
     *     - enum, exists
     */
    protected function ruleToTypescript($rule)
    {
        return match ($rule) {
            'int' => 'number',
            'integer' => 'number',
            'string' => 'string',
            'bool' => 'boolean',
            'boolean' => 'boolean',
            'bigint' => 'number',
            'number' => 'number',
            default => 'string',
        };
    }

}