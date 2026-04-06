<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

/**
 * @template TSource of \Honed\Chart\Chartable
 * 
 * @method TSource show(bool $value = true)
 * @method TSource dontShow()
 * @method bool isShown()
 * @method TSource trigger(string|Trigger $value)
 * @method TSource triggerByItem()
 * @method TSource triggerByAxis()
 * @method TSource dontTrigger()
 * @method string|Trigger getTrigger()
 * 
 * @extends \Honed\Chart\Proxies\HigherOrderProxy<TSource, \Honed\Chart\Tooltip>
 */
class HigherOrderTooltip extends HigherOrderProxy
{
    //
}