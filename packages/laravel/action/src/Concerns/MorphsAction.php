<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Honed\Action\Creator;

trait MorphsAction
{
    abstract public function type();

    /**
     * @return $this
     */
    public function morph()
    {
        $this->type(Creator::Polymorphic);

        return $this;
    }
}