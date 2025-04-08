<?php

declare(strict_types=1);

namespace Honed\Form\Tests\Fixtures;

use Honed\Form\Concerns\HasForm;
use Illuminate\Foundation\Http\FormRequest;

class BasicRequest extends FormRequest
{
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
