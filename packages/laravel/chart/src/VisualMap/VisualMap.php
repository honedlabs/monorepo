<?php

declare(strict_types=1);

namespace Honed\Chart\VisualMap;

use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

/**
 * @internal
 */
abstract class VisualMap extends Primitive implements NullsAsUndefined
{
    use HasId;
    use HasTextStyle;
    use HasZAxis;

    public static function make(): static
    {
        return resolve(static::class);
    }

    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            'textStyle' => $this->getTextStyle()?->toArray(),
        ];
    }
}
