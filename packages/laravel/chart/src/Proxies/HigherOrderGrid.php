<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource id(?string $id) Set the grid id.
 * @method ?string getId() Get the grid id.
 * @method TSource tooltip(\Honed\Chart\Tooltip|\Closure(\Honed\Chart\Tooltip): \Honed\Chart\Tooltip|bool|null $value = true) Set or configure the grid tooltip.
 * @method ?\Honed\Chart\Tooltip getTooltip() Get the grid tooltip instance.
 * @method TSource left(?string $value) Set the grid inset from the left.
 * @method ?string getLeft() Get the left inset.
 * @method TSource right(?string $value) Set the grid inset from the right.
 * @method ?string getRight() Get the right inset.
 * @method TSource bottom(?string $value) Set the grid inset from the bottom.
 * @method ?string getBottom() Get the bottom inset.
 * @method TSource containLabel(bool $value = true) Whether the grid should contain axis labels within its box.
 * @method ?bool getContainLabel() Whether the grid contains labels.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Grid>
 */
class HigherOrderGrid extends HigherOrderProxy
{
    //
}
