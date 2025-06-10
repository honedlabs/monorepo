<?php

namespace Honed\Table\Concerns;

trait CanSelect
{
    protected $selectable = false;

    protected $select = [];

    public function selectable()
    {

    }
}