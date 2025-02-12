<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Honed\Table\Http\Requests\TableActionRequest;
use Honed\Table\Tests\Fixtures\Table;
use Illuminate\Routing\Controller;

class BindingsController extends Controller
{
    public function action(TableActionRequest $request, Table $table)
    {
        return $table->handle($request);
    }
}
