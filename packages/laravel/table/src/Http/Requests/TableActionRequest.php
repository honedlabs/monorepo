<?php

declare(strict_types=1);

namespace Honed\Table\Http\Requests;

use Honed\Table\Http\InvokedController;
use Honed\Action\Http\Requests\ActionRequest;

class TableActionRequest extends ActionRequest

{
    /**
     * Get the validation rules that apply to the request.

     *
     * @return array<string,array<int,mixed>>
     */
    public function rules(): array
    {
        return \array_merge(parent::rules(), [
            InvokedController::TableKey => ['required', 'string'],
        ]);
    }


}