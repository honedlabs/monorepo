<?php

namespace {{ namespace }};

use Honed\List\List;

class {{ class }} extends List
{
    /**
     * Define the list.
     * 
     * @param  $this  $list
     * @return $this
     */
    public function definition(List $list): List
    {
        return $list;
    }
}