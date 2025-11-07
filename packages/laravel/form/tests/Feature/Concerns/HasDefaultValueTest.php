<?php

declare(strict_types=1);

use Honed\Form\Components\Textarea;

beforeEach(function () {
    $this->component = Textarea::make('description');
});

it('has default value', function () {
    expect($this->component)
        ->getDefaultValue()->toBe('')
        ->empty()->toBe('')
        ->defaultValue('value')->toBe($this->component)
        ->getDefaultValue()->toBe('value');
});
