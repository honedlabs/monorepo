<?php

use Workbench\App\Models\User;
use Illuminate\Support\Facades\Session;
use Honed\Refine\Persistence\CookieDriver;
use Honed\Refine\Persistence\SessionDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Cookie as HttpFoundationCookie;

beforeEach(function () {
    $request = Request::create('/', cookies: [
        'cookie' => json_encode(['key' => 'value'])
    ]);

    $this->driver = CookieDriver::make('cookie')
        ->request($request)
        ->resolve();
});

it('can persist data to a queued cookie', function () {
    $this->driver->put('key', 'value');

    $this->driver->persist();

    expect(Cookie::getQueuedCookies())
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->getName()->toEqual('cookie');
});

it('can retrieve all data from cookie', function () {
    expect($this->driver->get())->toEqual(['key' => 'value']);
});

it('can retrieve data from cookie', function () {
    expect($this->driver->get('key'))->toEqual('value');
});

it('retrieves null when the key does not exist', function () {
    expect($this->driver->get('invalid'))->toBeNull();
});
