<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

use Honed\Action\Confirm;

/**
 * @phpstan-require-extends \Honed\Action\Action
 */
interface Confirms
{
    public function confirm(): Confirm;
}