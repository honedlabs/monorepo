<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Form;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * 
 * @phpstan-require-extends \Illuminate\Foundation\Http\FormRequest
 */ 
trait HasForm
{
    /**
     * The underlying form object.
     * 
     * @var \Honed\Form\Form|null
     */
    protected $form;

    /**
     * Convert the form request to a form object.
     * 
     * @return \Honed\Form\Form
     */
    public static function asForm()
    {
        $request = new self();

        return $request->formInstance();
    }

    /**
     * Get an instance of the form object.
     * 
     * @return \Honed\Form\Form
     */
    public function formInstance()
    {
        return $this->form ??= Form::make($this->validationRules());
    }

    /**
     * Set the configuration to use for the form via a callback.
     * 
     * @param \Honed\Form\Form $form
     * @return void
     */
    public function form($form)
    {
        return;
    }

    /**
     * Get the validated data after it has been processed by the form.
     * 
     * @return array<string, mixed>
     */
    public function getFormData()
    {
        // if ($this->fails()) {

        // }
        return $this->formInstance()
            ->transform($this->safe());
    }

    /**
     * Use the form configuration to store a new model record.
     * 
     * @param class-string<TModel> $modelClass
     * @return TModel
     */
    public function store($modelClass)
    {

        return $modelClass::query()
            ->create($this->getFormData());
    }

    /**
     * Use the form configuration to update an existing model record.
     * 
     * @param TModel $model
     * @return int
     */
    public function update($model)
    {
        return $model->query()
            ->update($this->getFormData());
    }

    /**
     * Use the form configuration to delete a model record.
     * 
     * @param TModel $model
     * @return mixed
     */
    public function destroy($model)
    {
        return $model->query()->delete();
    }
}