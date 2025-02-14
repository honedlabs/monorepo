<?php

declare(strict_types=1);

namespace Honed\Table\Http;

use Honed\Table\Http\Requests\TableRequest;
use Honed\Table\Concerns\HasTableBindings;

class InvokedController
{
    const TableKey = 'table';

    use HasTableBindings;

    /**
     * Delegate the incoming action request to the appropriate table.
     * 
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|void
     */
    public function __invoke(TableRequest $request)
    {
        $table = $this->resolveRouteBinding(
            $request->validated(self::TableKey)
        );

        abort_if(! $table, 404);

        return $table->handle($request);
    }
}