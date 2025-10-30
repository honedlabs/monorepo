<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Honed\Data\Support\AbstractRegexRule;

class Youtube extends AbstractRegexRule
{
    /**
     * REGEX pattern of rule
     */
    protected function pattern(): string
    {
        return "/^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([a-zA-Z0-9_-]{11})(?:[?&].*|#.+)?$/i";
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'youtube';
    }
}
