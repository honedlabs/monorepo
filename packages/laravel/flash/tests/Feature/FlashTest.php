<?php

declare(strict_types=1);

use Honed\Flash\Facades\Flash;
use Honed\Flash\FlashFactory;
use Illuminate\Support\Facades\Session;

it('sets message', function () {
    expect(Flash::message('test'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'test',
            'type' => config('flash.type'),
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});

it('sets success message', function () {
    expect(Flash::success('test'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'test',
            'type' => 'success',
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});

it('sets error message', function () {
    expect(Flash::error('test'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'test',
            'type' => 'error',
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});

it('sets info message', function () {
    expect(Flash::info('test'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'test',
            'type' => 'info',
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});

it('sets warning message', function () {
    expect(Flash::warning('test'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'test',
            'type' => 'warning',
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});

it('sets property', function () {
    expect(Flash::getProperty())
        ->toBe('flash');

    expect(Flash::property('test'))
        ->toBeInstanceOf(FlashFactory::class)
        ->getProperty()->toBe('test');
});

it('has helper methods', function () {
    expect(flash()->success('Hello world'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'Hello world',
            'type' => 'success',
            'title' => null,
            'duration' => config('flash.duration'),
        ]);

    expect(flash('Hello world', 'error'))
        ->toBeInstanceOf(FlashFactory::class);

    expect(Session::get('flash'))
        ->toEqual([
            'message' => 'Hello world',
            'type' => 'error',
            'title' => null,
            'duration' => config('flash.duration'),
        ]);
});
