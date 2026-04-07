<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the label line.
 * @method TSource dontShow() Hide the label line.
 * @method ?bool isShown() Whether the label line is shown.
 * @method TSource length(int|float|null $value) Set the length of the first segment.
 * @method int|float|null getLength() Get the first segment length.
 * @method TSource length2(int|float|null $value) Set the length of the second segment.
 * @method int|float|null getLength2() Get the second segment length.
 * @method TSource smooth(bool $value = true) Enable or disable smoothing on the label line.
 * @method ?bool getSmooth() Whether the line is smoothed.
 * @method TSource lineStyle(\Honed\Chart\LineStyle|\Closure(\Honed\Chart\LineStyle): \Honed\Chart\LineStyle|bool|null $value = true) Set or configure the label line stroke style.
 * @method ?\Honed\Chart\LineStyle getLineStyle() Get the label line stroke style instance.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\LabelLine>
 */
class HigherOrderLabelLine extends HigherOrderProxy
{
    //
}
