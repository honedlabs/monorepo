<?php

declare(strict_types=1);

namespace Honed\Data\Support;

use Honed\Data\Concerns\TranslatesErrorMessages;
use Intervention\Validation\AbstractRule as InterventionAbstractRule;

abstract class AbstractRule extends InterventionAbstractRule
{
    use TranslatesErrorMessages;
}
