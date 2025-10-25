<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Intervention\Validation\AbstractRegexRule;

class Vimeo extends AbstractRegexRule
{
    /**
     * REGEX pattern of rule
     */
    protected function pattern(): string
    {
        return '/^(?:https?:\/\/)?(?:www\.|player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:\?.*)?(?:#.*)?$/i';
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'vimeo';
    }
}
