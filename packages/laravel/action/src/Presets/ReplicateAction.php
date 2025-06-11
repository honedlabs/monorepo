<?php

namespace Honed\Action\Presets;

use Honed\Action\Contracts\Actionable;
use Honed\Action\InlineAction;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class ReplicateAction extends InlineAction implements Actionable
{
    public function handle($model)
    {
        
    }
}