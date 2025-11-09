<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Status;
use Honed\Form\Concerns\GeneratesForm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    use GeneratesForm;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => 'nullable|string|max:65535',
            'price' => ['required', 'integer', 'min:0', 'max:999'],
            'best_seller' => ['required', 'boolean'],
            'status' => ['required', Rule::enum(Status::class)],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'users' => ['required', 'array', 'min:1'],
            'users.*' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
