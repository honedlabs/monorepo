<?php

declare(strict_types=1);

namespace Honed\List;

use Honed\Core\Primitive;

class Infolist extends Primitive
{
    use Concerns\HasEntries;

    /**
     * Define the list.
     *
     * @param  \Honed\List\Infolist  $infolist
     * @return \Honed\List\Infolist
     */
    protected function definition(Infolist $list): Infolist
    {
        return $list;
    }

    public function toArray($named = [], $typed = [])
    {
        return $this->entriesToArray();
    }
}