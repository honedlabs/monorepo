<?php

declare(strict_types=1);

namespace Honed\Table\Actions;

use Honed\Action\Contracts\Action;
use Honed\Table\Table;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class ViewAction extends Action
{
    /**
     * The translator instance.
     *
     * @var \Illuminate\Contracts\Translation\Translator
     */
    protected Translator $translator;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $this->translator = app(Translator::class);
    }

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

    /**
     * Fail the action due to the table not being viewable.
     *
     * @param string $field
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function invalid(string $field, ?string $action): void
    {
        $this->fail($field, $this->translator->get('table::messages.view.missing', [
            'action' => $action ?? 'access',
        ]));
    }

    /**
     * Fail the action due to the view name not being unique.
     *
     * @param string $field
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function notUnique(string $field): void
    {
        $this->fail($field, $this->translator->get('table::messages.view.name.unique', [
            'attribute' => $field,
        ]));
    }
}