<?php

declare(strict_types=1);

namespace Honed\Table\Actions;

use Honed\Action\Actions\StoreAction;

/**
 * @extends \Honed\Action\Actions\StoreAction<\Honed\Table\Models\View>
 */
class StoreView extends StoreAction
{
    /**
     * Get the model class for the action.
     */
    public function for()
    {
        return View::class;
    }

}