<?php

declare(strict_types=1);

use Honed\Form\Components\Password;

beforeEach(function () {
    $this->component = Password::make('password');
});

it('has password type', function () {
    expect($this->component)
        ->getAttributes()->toEqualCanonicalizing([
            'type' => 'password',
        ]);
});
