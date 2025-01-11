<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

use Honed\Action\Confirm;

interface Confirms
{
    public function confirm(): Confirm;
}