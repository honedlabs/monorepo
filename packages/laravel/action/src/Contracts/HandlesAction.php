<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

interface HandlesAction
{
    /**
     * Set the action's handler.
     * 
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $data
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|void
     */
    public function handle($data);
}