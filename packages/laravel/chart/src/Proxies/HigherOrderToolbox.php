<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the toolbox.
 * @method TSource dontShow() Hide the toolbox.
 * @method ?bool isShown() Whether the toolbox is shown.
 * @method TSource id(?string $id) Set the component id.
 * @method ?string getId() Get the component id.
 * @method TSource tooltip(\Honed\Chart\Tooltip|\Closure(\Honed\Chart\Tooltip): \Honed\Chart\Tooltip|bool|null $value = true) Set or configure the toolbox tooltip.
 * @method ?\Honed\Chart\Tooltip getTooltip() Get the toolbox tooltip instance.
 * @method TSource feature(array<string, mixed> $feature) Set the toolbox feature configuration (ECharts `feature`).
 * @method array<string, mixed>|null getFeature() Get the toolbox feature configuration.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Toolbox>
 */
class HigherOrderToolbox extends HigherOrderProxy
{
    //
}
