<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource borderType(string|int|list<int>|\Honed\Chart\Enums\BorderType $value) Set the line stroke type (solid, dashed, etc.).
 * @method TSource butt() Use flat line caps.
 * @method TSource cap(string|\Honed\Chart\Enums\Cap $value) Set how line endpoints are drawn.
 * @method TSource color(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the line color.
 * @method TSource colour(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the line color (British spelling alias).
 * @method TSource dashOffset(int $value) Set the dash offset along the line.
 * @method TSource dashed() Use a dashed line.
 * @method TSource dotted() Use a dotted line.
 * @method TSource inactiveColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the inactive line color.
 * @method TSource inactiveWidth(int|string $value) Set the inactive line width.
 * @method TSource join(string|\Honed\Chart\Enums\Join $value) Set how line segments join.
 * @method TSource bevel() Use bevel joins.
 * @method TSource miter(?int $value = null) Use miter joins, optionally setting the miter limit.
 * @method TSource miterLimit(?int $value) Set the miter limit ratio.
 * @method TSource opacity(?int $value) Set the line opacity.
 * @method TSource shadowBlur(int $value) Set the line shadow blur.
 * @method TSource shadowColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the line shadow color.
 * @method TSource shadowOffset(int $x, int $y) Set the line shadow offset on both axes.
 * @method TSource shadowOffsetX(int $value) Set the horizontal shadow offset.
 * @method TSource shadowOffsetY(int $value) Set the vertical shadow offset.
 * @method TSource solid() Use a solid line.
 * @method TSource square() Use square line caps.
 * @method TSource width(int|string $value) Set the line width.
 * @method string|int|list<int>|null getBorderType() Get the line stroke type.
 * @method ?string getCap() Get the line cap style.
 * @method string|array<string, mixed>|null getColor() Get the line color.
 * @method string|array<string, mixed>|null getColour() Get the line color (British spelling alias).
 * @method ?int getDashOffset() Get the dash offset.
 * @method string|array<string, mixed>|null getInactiveColor() Get the inactive line color.
 * @method int|string|null getInactiveWidth() Get the inactive line width.
 * @method ?string getJoin() Get the line join style.
 * @method ?int getMiterLimit() Get the miter limit.
 * @method ?int getOpacity() Get the line opacity.
 * @method ?int getShadowBlur() Get the shadow blur.
 * @method string|array<string, mixed>|null getShadowColor() Get the shadow color.
 * @method ?int getShadowOffsetX() Get the horizontal shadow offset.
 * @method ?int getShadowOffsetY() Get the vertical shadow offset.
 * @method int|string|null getWidth() Get the line width.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\LineStyle>
 */
class HigherOrderLineStyle extends HigherOrderProxy
{
    //
}
