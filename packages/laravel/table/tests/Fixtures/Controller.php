<?php

declare(strict_types=1);

namespace Honed\Table\Tests\Fixtures;

use Honed\Action\Http\Requests\ActionRequest;
use Honed\Table\Tests\Fixtures\Table;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function handle(ActionRequest $request, Table $table)
    {
        return $table->handle($request);
    }
}
