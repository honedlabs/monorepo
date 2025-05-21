<?php

declare(strict_types=1);

namespace Honed\Registry;

use Illuminate\Contracts\Support\Jsonable;

class Registry implements Jsonable
{
    protected $name;

    protected $homepage;

    protected $schema;
    
    public function toJson($options = 0)
    {
        return json_encode($this, $options);
    }

    // public function toArray()
    
    
}