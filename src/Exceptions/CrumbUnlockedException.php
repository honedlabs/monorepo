<?php

declare(strict_types=1);

namespace Honed\Crumb\Exceptions;

class CrumbUnlockedException extends \Exception
{
    public function __construct()
    {
        parent::__construct("The crumb is unlocked and optional adding is disallowed.");
    }
}