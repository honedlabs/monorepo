<?php

declare(strict_types=1);

use App\Forms\UserForm;
use Honed\Form\Attributes\UseForm;
use App\Models\User;

it('has attribute', function () {
    $attribute = new UseForm(UserForm::class);

    expect($attribute)
        ->toBeInstanceOf(UseForm::class)
        ->formClass->toBe(UserForm::class);

    expect(User::class)
        ->toHaveAttribute(UseForm::class);
});