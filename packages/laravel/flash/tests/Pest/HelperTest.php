<?php

declare(strict_types=1);

use Honed\Flash\FlashFactory;
use Honed\Flash\Support\Parameters;
use Illuminate\Support\Facades\Session;

it('has helper', function () {
    expect(flash())
        ->toBeInstanceOf(FlashFactory::class);
});

it('has helper with group', function () {
    expect(flash('A message'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'A message',
            'type' => config('flash.type'),
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});
