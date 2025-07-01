<?php

declare(strict_types=1);

namespace Honed\Table\Actions;

use Honed\Action\Contracts\Action;
use Honed\Table\Facades\Views;
use Honed\Table\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreView extends Action
{
    /**
     * Store a new view.
     *
     * @return object
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(
        Table $table,
        Request $request,
        string $field = 'name',
        mixed $scope = null
    ) {
        if ($table->isNotViewable()) {
            $this->fail($field, 'We were unable to store the view.');
        }


        Views::for($scope)->create(
            $table, $this->getName($request, $field), $this->state($table, $request)
        );
    }

    /**
     * Get the name of the view from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $field
     * @return string
     */
    protected function getName(Request $request, string $field): string
    {
        Validator::make($request->all(), [
            $field => ['required', 'string', 'max:255'],
        ])->validate();

        return $request->input($field);
    }

    /**
     * Create the state of the view from the request.
     *
     * @return array<string, mixed>
     */
    protected function state(Table $table, Request $request): array
    {
        $incoming = Request::create($request->header('referer'), Request::METHOD_GET);

        return $table->request($incoming)->toState();
    }

}
