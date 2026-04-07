<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the legend.
 * @method TSource dontShow() Hide the legend.
 * @method ?bool isShown() Whether the legend is shown.
 * @method TSource id(?string $id) Set the legend id.
 * @method ?string getId() Get the legend id.
 * @method TSource type(string|\Honed\Chart\Enums\LegendType $value) Set the legend layout type (plain or scroll).
 * @method TSource plain() Use a plain (non-scrolling) legend.
 * @method TSource scroll() Use a scrollable legend.
 * @method ?\Honed\Chart\Enums\LegendType getType() Get the legend type.
 * @method TSource labels(list<string> $labels) Set legend item names (ECharts `data`).
 * @method list<string>|null getLabels() Get legend item names.
 * @method TSource left(int|string|null $value) Set the legend position from the left.
 * @method TSource top(int|string|null $value) Set the legend position from the top.
 * @method TSource right(int|string|null $value) Set the legend position from the right.
 * @method TSource bottom(int|string|null $value) Set the legend position from the bottom.
 * @method TSource width(int|string $value) Set the legend width.
 * @method TSource height(int|string $value) Set the legend height.
 * @method TSource padding(int|array<int, int>|null $value) Set the legend padding.
 * @method TSource z(?int $value) Set the legend Z index.
 * @method TSource zLevel(?int $value) Set the legend Z level.
 * @method TSource inactiveColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the color for inactive legend items.
 * @method TSource inactiveBorderColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the border color for inactive legend items.
 * @method TSource inactiveWidth(int|string $value) Set the border width for inactive legend items.
 * @method int|string|null getLeft() Get the left offset.
 * @method int|string|null getTop() Get the top offset.
 * @method int|string|null getRight() Get the right offset.
 * @method int|string|null getBottom() Get the bottom offset.
 * @method int|string|null getWidth() Get the width.
 * @method int|string|null getHeight() Get the height.
 * @method int|array<int, int>|null getPadding() Get the padding.
 * @method ?int getZ() Get the Z index.
 * @method ?int getZLevel() Get the Z level.
 * @method string|array<string, mixed>|null getInactiveColor() Get the inactive item color.
 * @method string|array<string, mixed>|null getInactiveBorderColor() Get the inactive item border color.
 * @method int|string|null getInactiveWidth() Get the inactive item border width.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Legend>
 */
class HigherOrderLegend extends HigherOrderProxy
{
    //
}
