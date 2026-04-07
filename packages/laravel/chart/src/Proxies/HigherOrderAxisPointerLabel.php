<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the axis pointer label.
 * @method TSource dontShow() Hide the axis pointer label.
 * @method ?bool isShown() Whether the axis pointer label is shown.
 * @method TSource precision(int|string|null $value) Set numeric precision or formatting hint for the label.
 * @method int|string|null getPrecision() Get the precision setting.
 * @method TSource formatter(?string $value) Set the label formatter template or expression string.
 * @method ?string getFormatter() Get the formatter string.
 * @method TSource margin(int|float|list<int|float>|null $value) Set margin around the pointer label.
 * @method int|float|list<int|float>|null getPointerMargin() Get the pointer label margin.
 * @method TSource backgroundColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the label background color.
 * @method TSource borderColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the label border color.
 * @method TSource borderWidth(int $value) Set the label border width.
 * @method TSource textStyle(\Honed\Chart\TextStyle|\Closure(\Honed\Chart\TextStyle): \Honed\Chart\TextStyle|bool|null $value = true) Set or configure the label text style.
 * @method ?\Honed\Chart\TextStyle getTextStyle() Get the text style instance.
 * @method string|array<string, mixed>|null getBackgroundColor() Get the background color.
 * @method string|array<string, mixed>|null getBorderColor() Get the border color.
 * @method ?int getBorderWidth() Get the border width.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\AxisPointerLabel>
 */
class HigherOrderAxisPointerLabel extends HigherOrderProxy
{
    //
}
