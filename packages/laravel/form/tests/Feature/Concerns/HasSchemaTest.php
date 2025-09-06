<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

use Honed\Form\Components\Input;
use Honed\Form\Form;

beforeEach(function () {
    $this->input = Input::make('name');

    $this->form = Form::make();
});

it('has schema', function () {
    expect($this->form)
        ->getSchema()->toBe([])
        ->schema([$this->input])->toBe($this->form)
        ->getSchema()->toEqual([$this->input]);
});

it('converts schema to array', function () {
    expect($this->form)
        ->schemaToArray()->toBe([])
        ->schema([$this->input])->toBe($this->form)
        ->schemaToArray()->toEqual([$this->input->toArray()]);
});
