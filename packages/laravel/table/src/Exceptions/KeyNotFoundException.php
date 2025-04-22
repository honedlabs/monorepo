<?php

declare(strict_types=1);

namespace Honed\Table\Exceptions;

use Honed\Table\Table;

class KeyNotFoundException extends \Exception
{
    /**
     * Create a new key not found exception.
     * 
     * @param  \Honed\Table\Table<\Illuminate\Database\Eloquent\Model, \>|class-string  $table
     */
    public function __construct($table)
    {
        parent::__construct(
            \sprintf(
                'The table [%s] must have a key column or a key property defined.',
                $table instanceof Table ? $table::class : $table
            )
        );
    }

    /**
     * Throw a new key not found exception.
     * 
     * @param  string  $table
     * @return never
     * 
     * @throws \Honed\Table\Exceptions\KeyNotFoundException
     */
    public static function throw($table)
    {
        throw new self($table);
    }
}