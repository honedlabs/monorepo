<?php

namespace Conquest\Chart\Shared\Emphasis;

use Conquest\Chart\Shared\Concerns\IsDisabled;
use Conquest\Chart\Shared\Concerns\ShouldScale;
use Conquest\Chart\Shared\Emphasis\Concerns\HasBlurScope;
use Conquest\Chart\Shared\Emphasis\Concerns\HasFocus;
use Conquest\Core\Primitive;

class Emphasis extends Primitive
{
    use HasBlurScope;
    use HasFocus;
    use IsDisabled;
    use ShouldScale;

    public function __construct(
    ) {
        parent::__construct();
    }

    public static function make()
    {
        return resolve(static::class, func_get_args());

    }

    public function toArray(): array
    {
        // Only return the options that are set
        return array_filter([
            'scale' => $this->isScale(),
            'disabled' => $this->isDisabled(),
            'focus' => $this->getFocus(),
            // 'label' => $this->getLabelOptions(),
            // 'blurScope' => $this->getBlurScope(),
            // 'itemStyle' => $this->getItemStyleOptions(),
            // 'lineStyle' => $this->getLineStyleOptions(),
            // 'labelLine' => $this->getLabelLineOptions(),
        ]);
    }
}
