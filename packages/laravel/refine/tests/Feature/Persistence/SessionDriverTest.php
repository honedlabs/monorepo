<?php

use Honed\Refine\Persistence\SessionDriver;
use Illuminate\Support\Facades\Session;

it('can persist data to the session', function () {
    $driver = SessionDriver::make('session');

    $driver->put('key', 'value');

    $driver->persist();

    expect(Session::get('session'))->toEqual([
        'key' => 'value',
    ]);
});

it('can retrieve all data from the session', function () {
    Session::put('session', [
        'key' => 'value',
    ]);

    $driver = SessionDriver::make('session');

    expect($driver->get())->toEqual(['key' => 'value']);
});

it('can retrieve data from the session', function () {
    Session::put('session', [
        'key' => 'value',
    ]);

    $driver = SessionDriver::make('session');

    expect($driver->get('key'))->toEqual('value');
});

it('retrieves null when the key does not exist', function () {
    $driver = SessionDriver::make('session');

    expect($driver->get('key'))->toBeNull();
});
