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
}
