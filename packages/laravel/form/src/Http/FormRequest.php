<?php

declare(strict_types=1);

namespace Honed\Form\Http;

use Honed\Form\Concerns\HasForm;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * @use \Honed\Form\Concerns\HasForm<\Illuminate\Database\Eloquent\Model>
     */
    use HasForm;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'description' => ['nullable', 'string', 'min:1', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'best_seller' => ['required', 'boolean'],
        ];
    }
}
