<?php

namespace Honed\Crumb\Exceptions;


class DuplicateCrumbsException extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("There already exists a crumb with the name [$name]");
    }
}