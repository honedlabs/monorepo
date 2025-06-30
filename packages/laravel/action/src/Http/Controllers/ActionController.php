<?php

declare(strict_types=1);

namespace Honed\Action\Http\Controllers;

use Honed\Action\Batch;
use Honed\Action\Http\Requests\ActionRequest;
use Honed\Action\Operations\Operation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;

class ActionController extends Controller
{
    /**
     * Find and execute the appropriate action from route binding.
     *
     * @return \Illuminate\Contracts\Support\Responsable|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Honed\Action\Exceptions\InvalidOperationException
     * @throws \Honed\Action\Exceptions\OperationNotFoundException
     */
    public function __invoke(Request $request, Batch $batch, Operation $operation)
    {
        return $batch->handle($operation, $request);
    }
}
