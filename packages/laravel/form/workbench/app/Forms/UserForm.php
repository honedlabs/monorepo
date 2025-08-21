<?php

namespace App\Forms;

use Honed\Form\Components\Checkbox;
use Honed\Form\Components\FieldGroup;
use Honed\Form\Components\Fieldset;
use Honed\Form\Components\Input;
use Honed\Form\Components\Legend;
use Honed\Form\Components\Password;
use Honed\Form\Components\Text;
use Honed\Form\Form;

class UserForm extends Form
{    
    /**
     * Define the form.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this
            ->onCancelReset()
            ->action('/submit')
            ->schema([
                Fieldset::make([
                    Legend::make('User details'),
                    Text::make('Enter the details of the user.'),
                    FieldGroup::make([
                        Input::make('name')->required(),
                        Input::make('email')->required(),
                        Password::make('password')->required(),
                        Checkbox::make('remember_token', 'Remember me'),
                    ]),
                ])
            ]);
    }
}