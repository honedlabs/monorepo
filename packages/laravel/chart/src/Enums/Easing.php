<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Easing: string
{
    case Linear = 'linear';
    case QuadraticIn = 'quadraticIn';
    case QuadraticOut = 'quadraticOut';
    case QuadraticInOut = 'quadraticInOut';
    case CubicIn = 'cubicIn';
    case CubicOut = 'cubicOut';
    case CubicInOut = 'cubicInOut';
    case QuarticIn = 'quarticIn';
    case QuarticOut = 'quarticOut';
    case QuarticInOut = 'quarticInOut';
    case QuinticIn = 'quinticIn';
    case QuinticOut = 'quinticOut';
    case QuinticInOut = 'quinticInOut';
    case SinusoidalIn = 'sinusoidalIn';
    case SinusoidalOut = 'sinusoidalOut';
    case SinusoidalInOut = 'sinusoidalInOut';
    case ExponentialIn = 'exponentialIn';
    case ExponentialOut = 'exponentialOut';
    case ExponentialInOut = 'exponentialInOut';
    case CircularIn = 'circularIn';
    case CircularOut = 'circularOut';
    case CircularInOut = 'circularInOut';
    case ElasticIn = 'elasticIn';
    case ElasticOut = 'elasticOut';
    case ElasticInOut = 'elasticInOut';
    case BackIn = 'backIn';
    case BackOut = 'backOut';
    case BackInOut = 'backInOut';
    case BounceIn = 'bounceIn';
    case BounceOut = 'bounceOut';
    case BounceInOut = 'bounceInOut';
}