<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

/**
 * @phpstan-require-extends \Honed\Action\Action
 */
interface HasHandler
{
    /**
     * Set the action's handler.
     * 
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $data
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($data);
}