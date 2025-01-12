<?php

declare(strict_types=1);

namespace Honed\Action\Http\Requests;

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
        return [
            'name' => ['required', 'string'],
            'type' => ['required', 'in:bulk,inline'],
            
            'only' => ['exclude_if:type,inline', 'sometimes', 'array'],
            'except' => ['exclude_if:type,inline', 'sometimes', 'array'],
            'all' => ['exclude_if:type,inline', 'required', 'boolean'],
            'only.*' => ['exclude_if:type,inline', 'sometimes', 'string', 'integer'],
            'except.*' => ['exclude_if:type,inline', 'sometimes', 'string', 'integer']
            ,
            'id' => ['exclude_if:type,bulk', 'required', 'string', 'integer'],
        ];
    }
}
