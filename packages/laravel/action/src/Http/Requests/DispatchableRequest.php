<?php

declare(strict_types=1);

namespace Honed\Action\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispatchableRequest extends FormRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return \array_merge(parent::rules(), [
            'id' => ['required'],
        ]);
    }
}
