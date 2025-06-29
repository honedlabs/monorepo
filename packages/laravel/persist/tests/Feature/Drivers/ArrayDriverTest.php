<?php

declare(strict_types=1);

use Honed\Persist\Drivers\ArrayDriver;

beforeEach(function () {
    $this->driver = new ArrayDriver(config('persist.drivers.array.driver'));
});

it('is array driver', function () {
    expect($this->driver)
        ->getName()->toEqual(config('persist.drivers.array.driver'));
});

it('sets value', function () {
    $this->driver->put('test', 'test', 'test');

    expect($this->driver->get('test'))
        ->toEqual('test');
});

it('gets value', function () {
    $this->driver->put('test', 'test', 'test');
});