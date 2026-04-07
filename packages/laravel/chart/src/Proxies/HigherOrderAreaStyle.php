<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource color(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the area fill color.
 * @method TSource colour(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the area fill color (British spelling alias).
 * @method TSource opacity(?int $value) Set the area opacity.
 * @method TSource origin(string|int|\Honed\Chart\Enums\Origin $value) Set the fill origin.
 * @method TSource originAuto() Use automatic fill origin.
 * @method TSource originStart() Align the fill origin to the start.
 * @method TSource originEnd() Align the fill origin to the end.
 * @method TSource shadowBlur(int $value) Set the shadow blur radius.
 * @method TSource shadowColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the shadow color.
 * @method TSource shadowOffset(int $x, int $y) Set the shadow offset on both axes.
 * @method TSource shadowOffsetX(int $value) Set the horizontal shadow offset.
 * @method TSource shadowOffsetY(int $value) Set the vertical shadow offset.
 * @method string|array<string, mixed>|null getColor() Get the fill color.
 * @method string|array<string, mixed>|null getColour() Get the fill color (British spelling alias).
 * @method ?int getOpacity() Get the opacity.
 * @method string|int|null getOrigin() Get the fill origin.
 * @method ?int getShadowBlur() Get the shadow blur radius.
 * @method string|array<string, mixed>|null getShadowColor() Get the shadow color.
 * @method ?int getShadowOffsetX() Get the horizontal shadow offset.
 * @method ?int getShadowOffsetY() Get the vertical shadow offset.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\AreaStyle>
 */
class HigherOrderAreaStyle extends HigherOrderProxy
{
    //
}
