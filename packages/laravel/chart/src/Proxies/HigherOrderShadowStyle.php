<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource color(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the shadow color.
 * @method TSource colour(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the shadow color (British spelling alias).
 * @method TSource opacity(?int $value) Set the shadow opacity.
 * @method TSource shadowBlur(int $value) Set the shadow blur radius.
 * @method TSource shadowOffset(int $x, int $y) Set the X and Y shadow offset together.
 * @method TSource shadowOffsetX(int $value) Set the horizontal shadow offset.
 * @method TSource shadowOffsetY(int $value) Set the vertical shadow offset.
 * @method string|array<string, mixed>|null getColor() Get the shadow color.
 * @method string|array<string, mixed>|null getColour() Get the shadow color (British spelling alias).
 * @method ?int getOpacity() Get the opacity.
 * @method ?int getShadowBlur() Get the shadow blur radius.
 * @method ?int getShadowOffsetX() Get the horizontal shadow offset.
 * @method ?int getShadowOffsetY() Get the vertical shadow offset.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\ShadowStyle>
 */
class HigherOrderShadowStyle extends HigherOrderProxy
{
    //
}
