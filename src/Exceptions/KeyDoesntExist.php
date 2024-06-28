<?php

namespace Conquest\Core\Exceptions;

use Conquest\Core\Contracts\Makeable;
use Exception;

class KeyDoesntExist extends Exception implements Makeable
{
    public function __construct()
    {
        parent::__construct("A function or property to resolve as the key doesn't exist.");
    }

    public static function make(): static
    {
        return resolve(static::class);
    }
}