<?php

declare(strict_types=1);

namespace Honed\Chart\Emphasis;

use Honed\Chart\Concerns\HasItemStyle;
use Honed\Chart\Concerns\HasLabel;
use Honed\Chart\Emphasis\Concerns\CanBeDisabled;
use Honed\Chart\Emphasis\Concerns\HasBlurScope;
use Honed\Chart\Emphasis\Concerns\HasFocus;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Emphasis extends Primitive implements NullsAsUndefined
{
    use CanBeDisabled;
    use HasBlurScope;
    use HasFocus;
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
            'label' => $this->getLabel()?->toArray(),
            'itemStyle' => $this->getItemStyle()?->toArray(),
        ];
    }
}
