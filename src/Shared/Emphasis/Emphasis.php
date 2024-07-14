<?php

namespace Conquest\Chart\Shared\Emphasis;

use Conquest\Core\Primitive;
use Conquest\Chart\Shared\Concerns\IsDisabled;
use Conquest\Chart\Shared\Concerns\ShouldScale;
use Conquest\Chart\Shared\Emphasis\Concerns\HasFocus;
use Conquest\Chart\Shared\Emphasis\Concerns\HasBlurScope;

class Emphasis extends Primitive
{
    use IsDisabled;
    use HasFocus;
    use HasBlurScope;
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