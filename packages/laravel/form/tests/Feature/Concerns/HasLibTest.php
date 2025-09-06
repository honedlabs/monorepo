<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

use Honed\Form\Form;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->lib = '@/UI/';

    $this->form = Form::make();
});

it('has lib', function () {
    expect($this->form)
        ->getLib()->toBe(Str::finish(config('form.lib'), '/'))
        ->lib($this->lib)->toBe($this->form)
        ->getLib()->toBe(Str::finish($this->lib, '/'));
});
