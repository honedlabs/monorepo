<?php

declare(strict_types=1);

namespace Honed\Crumb\Exceptions;

class NonTerminatingCrumbException extends \Exception
{
    public function __construct()
    {
        parent::__construct('This method is only available on terminating crumbs.');
    }
}
