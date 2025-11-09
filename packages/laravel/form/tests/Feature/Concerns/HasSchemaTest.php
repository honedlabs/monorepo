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
        ->resolveSchema()->toBe([])
        ->schema([$this->input])->toBe($this->form)
        ->resolveSchema()->toEqual([$this->input->toArray()]);
});

it('appends component to schema', function () {
    expect($this->form)
        ->getSchema()->toBe([])
        ->append($this->input)->toBe($this->form)
        ->getSchema()->toEqual([$this->input]);
});

it('prepends component to schema', function () {
    expect($this->form)
        ->getSchema()->toBe([])
        ->prepend($this->input)->toBe($this->form)
        ->getSchema()->toEqual([$this->input]);
});
