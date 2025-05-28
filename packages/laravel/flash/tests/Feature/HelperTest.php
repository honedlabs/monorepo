<?php

declare(strict_types=1);

use Honed\Flash\FlashFactory;
use Illuminate\Support\Facades\Session;

it('has helper', function () {
    expect(flash())
        ->toBeInstanceOf(FlashFactory::class);
});

it('has helper with group', function () {
    expect(flash('A message'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'A message',
            'type' => config('flash.type'),
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});
