<?php

declare(strict_types=1);

use Honed\Form\Form;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->form = Form::make();
});

it('has array representation', function () {
    expect($this->form)
        ->toArray()->toEqual([
            'schema' => [],
            'lib' => Str::finish(config('form.lib'), '/'),
            'method' => mb_strtolower(Request::METHOD_POST)
        ]);
});