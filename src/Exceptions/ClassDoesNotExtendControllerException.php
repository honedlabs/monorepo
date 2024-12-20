<?php

declare(strict_types=1);

namespace Honed\Crumb\Exceptions;

class ClassDoesNotExtendControllerException extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("Class [$name] does not extend the [Illuminate\Routing\Controller] controller base class.");
    }
}
