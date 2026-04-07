<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the label.
 * @method TSource dontShow() Hide the label.
 * @method ?bool isShown() Whether the label is shown.
 * @method TSource backgroundColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the label background color.
 * @method TSource borderColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the label border color.
 * @method TSource borderRadius(int|array<int, int> $value) Set the label border radius.
 * @method TSource borderType(string|int|list<int>|\Honed\Chart\Enums\BorderType $value) Set the label border stroke type.
 * @method TSource borderWidth(int $value) Set the label border width.
 * @method TSource color(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the label text color.
 * @method TSource colour(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the label text color (British spelling alias).
 * @method TSource dashOffset(int $value) Set the border dash offset.
 * @method TSource dashed() Use a dashed border.
 * @method TSource dotted() Use a dotted border.
 * @method TSource fontFamily(string|\Honed\Chart\Enums\FontFamily $value) Set the font family.
 * @method TSource fontSize(int $value) Set the font size.
 * @method TSource fontStyle(\Honed\Chart\Enums\FontStyle|string $value) Set the font style.
 * @method TSource fontWeight(\Honed\Chart\Enums\FontWeight|int|string $value) Set the font weight.
 * @method TSource height(int|string $value) Set the label height.
 * @method TSource italic() Set the font style to italic.
 * @method TSource lineHeight(int $value) Set the line height.
 * @method TSource monospace() Use a monospace font stack.
 * @method TSource oblique() Set the font style to oblique.
 * @method TSource overflow(string|\Honed\Chart\Enums\Overflow $value) Set how overflowing label text is handled.
 * @method TSource padding(int|array<int, int>|null $value) Set the label padding.
 * @method TSource sansSerif() Use a sans-serif font stack.
 * @method TSource shadowBlur(int $value) Set the label shadow blur.
 * @method TSource shadowColor(string|\Honed\Chart\Style\Rgb|\Honed\Chart\Style\Rgba|\Honed\Chart\Style\Gradient|null $value) Set the label shadow color.
 * @method TSource shadowOffset(int $x, int $y) Set the label shadow offset on both axes.
 * @method TSource shadowOffsetX(int $value) Set the horizontal label shadow offset.
 * @method TSource shadowOffsetY(int $value) Set the vertical label shadow offset.
 * @method TSource solid() Use a solid border.
 * @method TSource bold() Set the font weight to bold.
 * @method TSource bolder() Set the font weight to bolder.
 * @method TSource lighter() Set the font weight to lighter.
 * @method TSource break() Wrap overflowing text with line breaks.
 * @method TSource breakAll() Break overflowing text at any character.
 * @method TSource truncate() Truncate overflowing text with an ellipsis.
 * @method TSource width(int|string $value) Set the label width.
 * @method string|array<string, mixed>|null getBackgroundColor() Get the background color.
 * @method string|array<string, mixed>|null getBorderColor() Get the border color.
 * @method int|array<int, int>|null getBorderRadius() Get the border radius.
 * @method string|int|list<int>|null getBorderType() Get the border stroke type.
 * @method ?int getBorderWidth() Get the border width.
 * @method string|array<string, mixed>|null getColor() Get the text color.
 * @method string|array<string, mixed>|null getColour() Get the text color (British spelling alias).
 * @method ?int getDashOffset() Get the border dash offset.
 * @method ?string getFontFamily() Get the font family.
 * @method ?int getFontSize() Get the font size.
 * @method ?string getFontStyle() Get the font style.
 * @method string|int|null getFontWeight() Get the font weight.
 * @method int|string|null getHeight() Get the label height.
 * @method ?int getLineHeight() Get the line height.
 * @method ?string getOverflow() Get the overflow strategy.
 * @method int|array<int, int>|null getPadding() Get the padding.
 * @method ?int getShadowBlur() Get the shadow blur.
 * @method string|array<string, mixed>|null getShadowColor() Get the shadow color.
 * @method ?int getShadowOffsetX() Get the horizontal shadow offset.
 * @method ?int getShadowOffsetY() Get the vertical shadow offset.
 * @method int|string|null getWidth() Get the label width.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Label>
 */
class HigherOrderLabel extends HigherOrderProxy
{
    //
}
