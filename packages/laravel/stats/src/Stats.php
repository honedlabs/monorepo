<?php

declare(strict_types=1);

namespace Honed\Stats;

use Honed\Core\Primitive;

class Stats extends Primitive
{
    public function getKeys()
    {
        return [
            'label',
            'value',
        ];
    }

    public function getStats()
    {
        return [
            'value' => 'called'
        ];
    }
}