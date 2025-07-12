<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Actions\Concerns\Transactable;
use Honed\Action\Contracts\Action;

// /**
//  * @method perform(mixed ...$parameters)
//  */
abstract class DatabaseAction implements Action
{
    use Transactable;
}
