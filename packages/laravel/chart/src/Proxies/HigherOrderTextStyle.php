<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource borderColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the text outline color.
 * @method TSource borderType(string|int|list<int>|\Honed\Chart\Enums\BorderType $value) Set the text outline stroke type.
 * @method TSource borderWidth(int $value) Set the text outline width.
 * @method TSource color(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the text color.
 * @method TSource colour(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the text color (British spelling alias).
 * @method TSource dashed() Use a dashed text outline.
 * @method TSource dotted() Use a dotted text outline.
 * @method TSource fontFamily(string|\Honed\Chart\Enums\FontFamily $value) Set the font family.
 * @method TSource fontSize(int $value) Set the font size.
 * @method TSource fontStyle(\Honed\Chart\Enums\FontStyle|string $value) Set the font style (e.g. italic).
 * @method TSource fontWeight(\Honed\Chart\Enums\FontWeight|int|string $value) Set the font weight.
 * @method TSource height(int|string $value) Set the text box height.
 * @method TSource italic() Set the font style to italic.
 * @method TSource lineHeight(int $value) Set the line height.
 * @method TSource monospace() Use a monospace font stack.
 * @method TSource oblique() Set the font style to oblique.
 * @method TSource overflow(string|\Honed\Chart\Enums\Overflow $value) Set how overflowing text is handled.
 * @method TSource sansSerif() Use a sans-serif font stack.
 * @method TSource shadowBlur(int $value) Set the text shadow blur.
 * @method TSource shadowColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the text shadow color.
 * @method TSource shadowOffset(int $x, int $y) Set the text shadow offset on both axes.
 * @method TSource shadowOffsetX(int $value) Set the horizontal text shadow offset.
 * @method TSource shadowOffsetY(int $value) Set the vertical text shadow offset.
 * @method TSource solid() Use a solid text outline.
 * @method TSource bold() Set the font weight to bold.
 * @method TSource bolder() Set the font weight to bolder.
 * @method TSource lighter() Set the font weight to lighter.
 * @method TSource break() Wrap overflowing text with line breaks.
 * @method TSource breakAll() Break overflowing text at any character.
 * @method TSource truncate() Truncate overflowing text with an ellipsis.
 * @method TSource width(int|string $value) Set the text box width.
 * @method string|array<string, mixed>|null getBorderColor() Get the text outline color.
 * @method string|int|list<int>|null getBorderType() Get the text outline stroke type.
 * @method ?int getBorderWidth() Get the text outline width.
 * @method string|array<string, mixed>|null getColor() Get the text color.
 * @method string|array<string, mixed>|null getColour() Get the text color (British spelling alias).
 * @method ?string getFontFamily() Get the font family.
 * @method ?int getFontSize() Get the font size.
 * @method ?string getFontStyle() Get the font style.
 * @method string|int|null getFontWeight() Get the font weight.
 * @method int|string|null getHeight() Get the text box height.
 * @method ?int getLineHeight() Get the line height.
 * @method ?string getOverflow() Get the overflow strategy.
 * @method ?int getShadowBlur() Get the text shadow blur.
 * @method string|array<string, mixed>|null getShadowColor() Get the text shadow color.
 * @method ?int getShadowOffsetX() Get the horizontal text shadow offset.
 * @method ?int getShadowOffsetY() Get the vertical text shadow offset.
 * @method int|string|null getWidth() Get the text box width.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\TextStyle>
 */
class HigherOrderTextStyle extends HigherOrderProxy
{
    //
}
