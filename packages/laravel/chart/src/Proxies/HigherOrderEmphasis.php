<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource disabled(bool $value = true) Disable emphasis styling for this element.
 * @method TSource enableEmphasis() Re-enable emphasis styling.
 * @method ?bool getDisabled() Whether emphasis is disabled.
 * @method TSource scale(bool $value = true) Enable or disable emphasis scaling animation.
 * @method ?bool getScale() Whether emphasis scaling is enabled.
 * @method TSource scaleSize(int|float|null $value) Set the emphasis scale size multiplier.
 * @method int|float|null getScaleSize() Get the emphasis scale size.
 * @method TSource focus(string|\Honed\Chart\Enums\Focus $value) Set which related components stay focused when emphasized.
 * @method ?\Honed\Chart\Enums\Focus getEmphasisFocus() Get the emphasis focus mode.
 * @method TSource blurScope(string|\Honed\Chart\Enums\BlurScope $value) Set how non-focused elements are dimmed.
 * @method ?\Honed\Chart\Enums\BlurScope getEmphasisBlurScope() Get the blur scope for de-emphasized elements.
 * @method TSource label(\Honed\Chart\Label|\Closure(\Honed\Chart\Label): \Honed\Chart\Label|bool|null $value = true) Set or configure the emphasis label.
 * @method ?\Honed\Chart\Label getLabel() Get the emphasis label instance.
 * @method TSource labelLine(\Honed\Chart\LabelLine|\Closure(\Honed\Chart\LabelLine): \Honed\Chart\LabelLine|bool|null $value = true) Set or configure the emphasis label line.
 * @method ?\Honed\Chart\LabelLine getLabelLine() Get the emphasis label line instance.
 * @method TSource itemStyle(\Honed\Chart\ItemStyle|\Closure(\Honed\Chart\ItemStyle): \Honed\Chart\ItemStyle|bool|null $value = true) Set or configure the emphasis item style.
 * @method ?\Honed\Chart\ItemStyle getItemStyle() Get the emphasis item style instance.
 * @method TSource lineStyle(\Honed\Chart\LineStyle|\Closure(\Honed\Chart\LineStyle): \Honed\Chart\LineStyle|bool|null $value = true) Set or configure the emphasis line style.
 * @method ?\Honed\Chart\LineStyle getLineStyle() Get the emphasis line style instance.
 * @method TSource areaStyle(\Honed\Chart\AreaStyle|\Closure(\Honed\Chart\AreaStyle): \Honed\Chart\AreaStyle|bool|null $value = true) Set or configure the emphasis area style.
 * @method ?\Honed\Chart\AreaStyle getAreaStyle() Get the emphasis area style instance.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Emphasis>
 */
class HigherOrderEmphasis extends HigherOrderProxy
{
    //
}
