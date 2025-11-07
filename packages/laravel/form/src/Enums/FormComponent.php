<?php

declare(strict_types=1);

namespace Honed\Form\Enums;

enum FormComponent: string
{
    case Checkbox = 'checkbox';
    case Date = 'date';
    case FieldGroup = 'fieldgroup';
    case Fieldset = 'fieldset';
    case Input = 'input';
    case Legend = 'legend';
    case Lookup = 'lookup';
    case Password = 'password';
    case Radio = 'radio';
    case Select = 'select';
    case Text = 'text';
    case Textarea = 'textarea';
}
