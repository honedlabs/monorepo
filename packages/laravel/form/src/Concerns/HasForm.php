<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Attributes\UseForm;
use Honed\Form\Form;
use ReflectionClass;

/**
 * @template TForm of \Honed\Form\Form = \Honed\Form\Form
 *
 * @property-read string $formClass The form class for the model.
 */
trait HasForm
{
    /**
     * Get the form instance for the model.
     *
     * @param  class-string<Form>|null  $form
     * @return TForm
     */
    public static function form(?string $form = null): Form
    {
        return static::newForm() ?? Form::formForModel(static::class);
    }

    /**
     * Create a new form instance for the model.
     *
     * @return TForm|null
     */
    protected static function newForm(): ?Form
    {
        if (isset(static::$formClass)) {
            return static::$formClass::make();
        }

        if ($form = static::getUseFormAttribute()) {
            return $form::make();
        }

        return null;
    }

    /**
     * Get the form from the Form class attribute.
     *
     * @return TForm|null
     */
    protected static function getUseFormAttribute(): ?Form
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseForm::class);

        if ($attributes !== []) {
            $useForm = $attributes[0]->newInstance();

            $form = $useForm->formClass::make();

            return $form;
        }

        return null;
    }
}
