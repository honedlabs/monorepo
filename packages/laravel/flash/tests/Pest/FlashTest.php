<?php

declare(strict_types=1);

use Honed\Flash\Facades\Flash;
use Honed\Flash\Flash as BaseFlash;
use Honed\Flash\Support\Parameters;
use Illuminate\Support\Facades\Session;

it('sets message', function () {
    expect(Flash::message('test', meta: ['test' => 'test']))
        ->toBeInstanceOf(BaseFlash::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'test',
            'type' => null,
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => ['test' => 'test'],
        ]);
});

it('sets success message', function () {
    expect(Flash::success('test'))
        ->toBeInstanceOf(BaseFlash::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'test',
            'type' => Parameters::SUCCESS,
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ]);
});

it('sets error message', function () {
    expect(Flash::error('test'))
        ->toBeInstanceOf(BaseFlash::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'test',
            'type' => Parameters::ERROR,
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ]);
});

it('sets info message', function () {
    expect(Flash::info('test'))
        ->toBeInstanceOf(BaseFlash::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'test',
            'type' => Parameters::INFO,
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ]);
});

it('sets warning message', function () {
    expect(Flash::warning('test'))
        ->toBeInstanceOf(BaseFlash::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'test',
            'type' => Parameters::WARNING,
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ]);
});
