<?php

declare(strict_types=1);

namespace Workbench\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<int,mixed>|string>
     */
    public function rules(): array
    {
        return [
            'abn' => ['required', 'abn'],
            'formatted_abn' => ['required', 'abn'],
        ];
    }
}
