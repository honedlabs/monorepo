<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Intervention\Validation\AbstractRegexRule;

class Youtube extends AbstractRegexRule
{
    /**
     * REGEX pattern of rule
     */
    protected function pattern(): string
    {
        return "/^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/i";
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'youtube';
    }
}
