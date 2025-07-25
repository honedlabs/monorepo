<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum TriggerOn: string
{
    case MouseMove = 'mousemove';
    case Click = 'click';
    case MouseMoveAndClick = 'mousemove|click';
    case None = 'none';
}