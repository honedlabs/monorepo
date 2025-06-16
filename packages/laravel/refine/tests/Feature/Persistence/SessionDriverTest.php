<?php

use Honed\Refine\Persistence\SessionDriver;
use Illuminate\Contracts\Session\Session as SessionContract;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

beforeEach(function () {
    $this->driver = SessionDriver::make('session');
});

it('can persist data to the session', function () {
    expect($this->driver)
        ->put('key', 'value')->toBe($this->driver);

    $this->driver->persist();

    expect(Session::get('session'))->toEqual([
        'key' => 'value',
    ]);
});

it('can merge data to the session', function () {
    $this->driver->put('key', ['key' => 'value']);

    expect($this->driver)
        ->merge('key', 'key2', 'value2')->toBe($this->driver);

    $this->driver->persist();

    expect(Session::get('session'))->toEqual([
        'key' => ['key' => 'value', 'key2' => 'value2'],
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
    expect($this->driver)
        ->get('key')->toBeNull();
});

it('can set the session', function () {
    $session = App::make(SessionContract::class);

    expect($this->driver)
        ->session($session)->toBe($this->driver);
});