<?php

declare(strict_types=1);

namespace Honed\Widget\Concerns;

use Honed\Widget\Facades\Widget;

trait HasWidgets
{
    /**
     * Get the widgets active for the model.
     * 
     * @param string|null $driver
     * @return mixed
     */
    public function widgets($driver = null)
    {
        return Widget::driver($driver)->for($this);
    }
}