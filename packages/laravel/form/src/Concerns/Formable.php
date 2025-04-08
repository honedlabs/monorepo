<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Form;

/**
 * @phpstan-require-extends \Illuminate\Foundation\Http\FormRequest
 */ 
trait Formable
{
    /**
     * Convert the form request to a form object.
     */
    public static function asForm()
    {
        $request = new self();

        return Form::make()
            ->from($request->rules());
    }

    public function store($modelClass)
    {

    }

    public function update($model)
    {

    }

    public function destroy($model)
    {

    }
}