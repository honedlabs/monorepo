<?php

namespace Honed\Table\Enums;

enum Paginator: string
{
    case LengthAware = 'length-aware';
    case Simple = 'simple';
    case Cursor = 'cursor';
    case Collection = 'collection';
}
