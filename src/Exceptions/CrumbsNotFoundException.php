<?php

namespace Honed\Crumb\Exceptions;


class CrumbsNotFoundException extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("There were no defined crumbs found for [$name]");
    }
}