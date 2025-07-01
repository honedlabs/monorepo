<?php

declare(strict_types=1);

namespace Honed\Table\Actions;

use Honed\Action\Contracts\Action;
use Honed\Table\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class ViewAction extends Action
{
    /**
     * Get the name of the view from a request.
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

    /**
     * Fail the action.
     *
     * @param string $field
     * @param string $message
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function fail(string $field, string $message): void
    {
        throw ValidationException::withMessages([
            $field => $message,
        ]);
    }
}