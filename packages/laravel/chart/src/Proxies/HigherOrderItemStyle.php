<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource borderColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the item border color.
 * @method TSource borderRadius(int|array<int, int> $value) Set the item border radius.
 * @method TSource borderType(string|int|list<int>|\Honed\Chart\Enums\BorderType $value) Set the item border stroke type.
 * @method TSource borderWidth(int $value) Set the item border width.
 * @method TSource butt() Use flat border caps.
 * @method TSource cap(string|\Honed\Chart\Enums\Cap $value) Set how border line endpoints are drawn.
 * @method TSource color(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the item fill color.
 * @method TSource colour(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the item fill color (British spelling alias).
 * @method TSource dashOffset(int $value) Set the border dash offset.
 * @method TSource dashed() Use a dashed border.
 * @method TSource dotted() Use a dotted border.
 * @method TSource join(string|\Honed\Chart\Enums\Join $value) Set how border segments join.
 * @method TSource bevel() Use bevel joins for the border.
 * @method TSource miter(?int $value = null) Use miter joins for the border, optionally setting the miter limit.
 * @method TSource miterLimit(?int $value) Set the border miter limit.
 * @method TSource opacity(?int $value) Set the item opacity.
 * @method TSource shadowBlur(int $value) Set the item shadow blur.
 * @method TSource shadowColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the item shadow color.
 * @method TSource shadowOffset(int $x, int $y) Set the item shadow offset on both axes.
 * @method TSource shadowOffsetX(int $value) Set the horizontal item shadow offset.
 * @method TSource shadowOffsetY(int $value) Set the vertical item shadow offset.
 * @method TSource solid() Use a solid border.
 * @method TSource square() Use square border caps.
 * @method string|array<string, mixed>|null getBorderColor() Get the border color.
 * @method int|array<int, int>|null getBorderRadius() Get the border radius.
 * @method string|int|list<int>|null getBorderType() Get the border stroke type.
 * @method ?int getBorderWidth() Get the border width.
 * @method ?string getCap() Get the border cap style.
 * @method string|array<string, mixed>|null getColor() Get the fill color.
 * @method string|array<string, mixed>|null getColour() Get the fill color (British spelling alias).
 * @method ?int getDashOffset() Get the border dash offset.
 * @method ?string getJoin() Get the border join style.
 * @method ?int getMiterLimit() Get the miter limit.
 * @method ?int getOpacity() Get the opacity.
 * @method ?int getShadowBlur() Get the shadow blur.
 * @method string|array<string, mixed>|null getShadowColor() Get the shadow color.
 * @method ?int getShadowOffsetX() Get the horizontal shadow offset.
 * @method ?int getShadowOffsetY() Get the vertical shadow offset.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\ItemStyle>
 */
class HigherOrderItemStyle extends HigherOrderProxy
{
    //
}
