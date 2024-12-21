<?php

namespace Conquest\Chart\Axis\Enums;

enum AxisType: string
{
    case VALUE = 'value';
    case CATEGORY = 'category';
    case TIME = 'time';
    case LOGARITHMIC = 'log';
}
