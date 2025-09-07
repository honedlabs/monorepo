<?php

declare(strict_types=1);

namespace App\Forms;

use App\Forms\Components\Combobox;
use Honed\Form\Components\Checkbox;
use Honed\Form\Components\FieldGroup;
use Honed\Form\Components\Fieldset;
use Honed\Form\Components\Input;
use Honed\Form\Components\Legend;
use Honed\Form\Components\Text;
use Honed\Form\Components\Textarea;
use Honed\Form\Form;

class ProductForm extends Form
{
    /**
     * Define the form.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this
            ->onCancelRedirect('/products')
            ->action('/products')
            ->schema([
                Fieldset::make([
                    Legend::make('Product details'),
                    Text::make('Enter the details of the product.'),
                    FieldGroup::make([
                        Input::make('name')->required(),
                        Textarea::make('description')->required(),
                        Input::make('price')->required(),
                        Combobox::make('user_id', 'User'),
                        Checkbox::make('best_seller', 'Best seller'),
                    ]),
                ]),
            ]);
    }
}
