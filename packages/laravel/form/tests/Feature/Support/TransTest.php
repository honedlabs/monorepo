<?php

declare(strict_types=1);

use Honed\Form\Support\Trans;

beforeEach(function () {
    $this->trans = new Trans('validation.required');
});

it('gets value', function () {
    expect($this->trans)
        ->key->toBe('validation.required')
        ->getValue()->toBe(__('validation.required'));
});
