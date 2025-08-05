<?php

declare(strict_types=1);

namespace Honed\Chart\Emphasis;

use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasLabel;
use Honed\Chart\Concerns\HasItemStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Chart\Emphasis\Concerns\HasFocus;
use Honed\Chart\Emphasis\Concerns\HasBlurScope;
use Honed\Chart\Emphasis\Concerns\CanBeDisabled;

class Emphasis extends Primitive implements NullsAsUndefined
{
    use CanBeDisabled;
    use HasFocus;
    use HasBlurScope;
    use HasItemStyle;
    use HasLabel;

    /**
     * Create a new emphasis instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the emphasis.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'disabled' => $this->isDisabled() ?: null,
            'focus' => $this->getFocus(),
            'blurScope' => $this->getBlurScope(),
            'itemStyle' => $this->getItemStyle()?->toArray(),
            'label' => $this->getLabel()?->toArray(),
        ];
    }
}