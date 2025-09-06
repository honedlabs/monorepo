<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

use Honed\Form\Enums\Cancel;
use Honed\Form\Form;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->form = Form::make();
});

it('has cancel action', function () {
    expect($this->form)
        ->getCancel()->toBeNull()
        ->onCancel('cancel')->toBe($this->form)
        ->getCancel()->toBe('cancel');
});

it('has cancel shorthands', function () {
    expect($this->form)
        ->onCancelRedirect('https://example.com')->toBe($this->form)
        ->getCancel()->toBe('https://example.com')
        ->onCancelReset()->toBe($this->form)
        ->getCancel()->toBe(Cancel::Reset->value)
        ->onCancelRoute('home')->toBe($this->form)
        ->getCancel()->toBe(route('home', [], false));
});

