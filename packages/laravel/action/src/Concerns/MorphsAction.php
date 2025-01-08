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
        if (\method_exists($this, 'hasLink') && $this->hasLink()) {
            // throw new CannotMorphLinkException();
        } 
        
        $this->type(Creator::Polymorphic);

        return $this;
    }
}