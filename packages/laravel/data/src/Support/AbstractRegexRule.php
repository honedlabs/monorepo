<?php

declare(strict_types=1);

namespace Honed\Data\Support;

use Honed\Data\Concerns\TranslatesErrorMessages;
use Intervention\Validation\AbstractRegexRule as InterventionAbstractRegexRule;

abstract class AbstractRegexRule extends InterventionAbstractRegexRule
{
    use TranslatesErrorMessages;
}
