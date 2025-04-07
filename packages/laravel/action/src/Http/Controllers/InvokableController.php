<?php

declare(strict_types=1);

namespace Honed\Action\Http\Controllers;

use Honed\Action\ActionGroup;
use Honed\Action\Http\Requests\ActionRequest;
use Illuminate\Routing\Controller;

class InvokableController extends Controller
{
    /**
     * Delegate the incoming action request to the appropriate table.
     *
     * @return \Illuminate\Contracts\Support\Responsable|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(ActionRequest $request)
    {
        /** @var string */
        $key = $request->validated('id');

        $primitive = $this->primitive();

        /** @var \Honed\Action\Contracts\Handles|null */
        $action = $primitive::getPrimitive($key, $primitive);

        abort_unless((bool) $action, 404);

        return $action->handle($request);
    }

    /**
     * Get the primitive class to use to handle the actions.
     *
     * @return string
     */
    public function primitive()
    {
        return ActionGroup::class;
    }
}
