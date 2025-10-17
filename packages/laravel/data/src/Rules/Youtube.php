<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Intervention\Validation\AbstractRegexRule;

class Youtube extends AbstractRegexRule
{
    /**
     * {@inheritdoc}
     *
     * @see AbstractRegexRule::pattern()
     */
    protected function pattern(): string
    {
        return "/^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/i";
    }
}
