<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the tooltip.
 * @method TSource dontShow() Hide the tooltip.
 * @method ?bool isShown() Whether the tooltip is shown.
 * @method TSource trigger(string|\Honed\Chart\Enums\Trigger $value) Set what mouse interaction opens the tooltip.
 * @method TSource triggerByItem() Open the tooltip when hovering individual data items.
 * @method TSource triggerByAxis() Open the tooltip when hovering along an axis.
 * @method TSource dontTrigger() Disable tooltip triggering.
 * @method ?\Honed\Chart\Enums\Trigger getTrigger() Get the current tooltip trigger mode.
 * @method TSource textStyle(\Honed\Chart\TextStyle|\Closure(\Honed\Chart\TextStyle): \Honed\Chart\TextStyle|bool|null $value = true) Set or configure tooltip label text styling.
 * @method ?\Honed\Chart\TextStyle getTextStyle() Get the tooltip text style instance.
 * @method TSource backgroundColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the tooltip background color.
 * @method TSource borderColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the tooltip border color.
 * @method TSource borderWidth(int $value) Set the tooltip border width.
 * @method TSource padding(int|array<int, int>|null $value) Set the tooltip padding.
 * @method TSource left(int|string|null $value) Set the distance from the container left edge.
 * @method TSource top(int|string|null $value) Set the distance from the container top edge.
 * @method TSource right(int|string|null $value) Set the distance from the container right edge.
 * @method TSource bottom(int|string|null $value) Set the distance from the container bottom edge.
 * @method TSource z(?int $value) Set the tooltip Z index within the canvas.
 * @method TSource zLevel(?int $value) Set the tooltip Z level (layer) for display ordering.
 * @method string|array<string, mixed>|null getBackgroundColor() Get the background color.
 * @method string|array<string, mixed>|null getBorderColor() Get the border color.
 * @method ?int getBorderWidth() Get the border width.
 * @method int|array<int, int>|null getPadding() Get the padding.
 * @method int|string|null getLeft() Get the left offset.
 * @method int|string|null getTop() Get the top offset.
 * @method int|string|null getRight() Get the right offset.
 * @method int|string|null getBottom() Get the bottom offset.
 * @method ?int getZ() Get the Z index.
 * @method ?int getZLevel() Get the Z level.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Tooltip>
 */
class HigherOrderTooltip extends HigherOrderProxy
{
    //
}
