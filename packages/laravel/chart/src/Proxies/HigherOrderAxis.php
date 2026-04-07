<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

use Closure;

/**
 * @template TSource of \Honed\Chart\Chartable
 *
 * @method TSource show(bool $value = true) Show or hide the axis.
 * @method TSource dontShow() Hide the axis.
 * @method ?bool isShown() Whether the axis is shown.
 * @method TSource type(string|\Honed\Chart\Enums\AxisType $value) Set the axis scale type (category, value, time, log).
 * @method TSource time() Use a time axis.
 * @method TSource log() Use a logarithmic axis.
 * @method ?\Honed\Chart\Enums\AxisType getType() Get the axis type.
 * @method bool hasType() Whether an axis type has been configured.
 * @method TSource boundaryGap(bool|array{0: int|float, 1: int|float} $value) Set padding at the axis min/max for category axes or tuple gap for value axes.
 * @method bool|array{0: int|float, 1: int|float}|null getBoundaryGap() Get the boundary gap setting.
 * @method TSource dimension(\Honed\Chart\Enums\Dimension|string $value) Set whether this axis is the X or Y dimension.
 * @method TSource x() Mark the axis as the X dimension.
 * @method TSource y() Mark the axis as the Y dimension.
 * @method \Honed\Chart\Enums\Dimension getDimension() Get the axis dimension.
 * @method TSource id(?string $id) Set the axis id.
 * @method ?string getId() Get the axis id.
 * @method TSource tooltip(\Honed\Chart\Tooltip|\Closure(\Honed\Chart\Tooltip): \Honed\Chart\Tooltip|bool|null $value = true) Set or configure the axis tooltip.
 * @method ?\Honed\Chart\Tooltip getTooltip() Get the axis tooltip instance.
 * @method TSource infer(bool $value = true) Enable automatic axis type inference from data.
 * @method TSource dontinfer() Disable automatic axis type inference.
 * @method bool infers() Whether type inference is enabled.
 * @method TSource from(list<mixed>|\Illuminate\Contracts\Support\Arrayable<int, mixed> $source) Set the raw data source (alias of `source()`).
 * @method TSource source(list<mixed>|\Illuminate\Contracts\Support\Arrayable<int, mixed>|null $source) Set the raw data source backing this axis.
 * @method list<mixed>|null getSource() Get the raw data source.
 * @method TSource category(string|\Closure|null $value) Set how category labels are read from each source row.
 * @method string|Closure|null getCategory() Get the category resolver.
 * @method bool hasCategory() Whether a category resolver is set.
 * @method TSource value(string|\Closure|null $value) Set how values are read from each source row.
 * @method string|Closure|null getValue() Get the value resolver.
 * @method bool hasValue() Whether a value resolver is set.
 * @method TSource data(list<mixed>|\Illuminate\Contracts\Support\Arrayable<int, mixed> $value) Set the explicit axis `data` array (categories or ordinal values).
 * @method bool hasData() Whether axis data has been set.
 * @method list<mixed>|null getData() Get the axis data array.
 * @method list<mixed>|null retrieve(list<mixed> $source, string|\Closure|null $value) Pluck or map values from a source array using a key or closure.
 * @method void resolve(mixed $data) Populate axis data and inferred type from a dataset.
 *
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Axis>
 */
class HigherOrderAxis extends HigherOrderProxy
{
    //
}
