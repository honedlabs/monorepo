<?php

declare(strict_types=1);

namespace Honed\Action\Http\Requests;

use Honed\Action\Creator;
use Illuminate\Foundation\Http\FormRequest;

class ActionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $excludeInline = \sprintf('exclude_if:type,%s', Creator::Inline);
        $excludeBulk = \sprintf('exclude_if:type,%s', Creator::Bulk);

        return [
            'name' => ['required', 'string'],
            'type' => ['required', \sprintf('in:%s,%s', Creator::Inline, Creator::Bulk)],
            
            'only' => [$excludeInline, 'sometimes', 'array'],
            'except' => [$excludeInline, 'sometimes', 'array'],
            'all' => [$excludeInline, 'required', 'boolean'],
            'only.*' => [$excludeInline, 'sometimes', 'string', 'integer'],
            'except.*' => [$excludeInline, 'sometimes', 'string', 'integer'],

            'id' => [$excludeBulk, 'required', 'string', 'integer'],
        ];
    }
}
