<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Honed\Table\Http\Requests\TableRequest;
use Honed\Table\Tests\Fixtures\Table;
use Illuminate\Routing\Controller;

class BindingsController extends Controller
{
    public function action(TableRequest $request, Table $table)
    {
        return $table->handle($request);
    }
}
