<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the title.
 * @method TSource dontShow() Hide the title.
 * @method ?bool isShown() Whether the title is shown.
 * @method TSource id(?string $id) Set the title component id.
 * @method ?string getId() Get the title component id.
 * @method TSource text(?string $value) Set the title text.
 * @method ?string getText() Get the title text.
 * @method TSource textStyle(\Honed\Chart\TextStyle|\Closure(\Honed\Chart\TextStyle): \Honed\Chart\TextStyle|bool|null $value = true) Set or configure the title text style.
 * @method ?\Honed\Chart\TextStyle getTextStyle() Get the title text style instance.
 * @method TSource left(int|string|null $value) Set the title position from the left.
 * @method TSource top(int|string|null $value) Set the title position from the top.
 * @method TSource right(int|string|null $value) Set the title position from the right.
 * @method TSource bottom(int|string|null $value) Set the title position from the bottom.
 * @method TSource z(?int $value) Set the title Z index.
 * @method TSource zLevel(?int $value) Set the title Z level for layering.
 * @method int|string|null getLeft() Get the left offset.
 * @method int|string|null getTop() Get the top offset.
 * @method int|string|null getRight() Get the right offset.
 * @method int|string|null getBottom() Get the bottom offset.
 * @method ?int getZ() Get the Z index.
 * @method ?int getZLevel() Get the Z level.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Title>
 */
class HigherOrderTitle extends HigherOrderProxy
{
    //
}
