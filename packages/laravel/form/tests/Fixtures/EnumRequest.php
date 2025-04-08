<?php

declare(strict_types=1);

namespace Honed\Form\Tests\Fixtures;

class EnumRequest extends BasicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return \array_merge(parent::rules(), [
            'status' => ['required', 'string', 'in:available,unavailable'],
        ]);
    }
}
