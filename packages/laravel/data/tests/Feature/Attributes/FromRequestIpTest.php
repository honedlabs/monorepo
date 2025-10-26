<?php

declare(strict_types=1);

use App\Data\IpData;
use Illuminate\Http\Request;

beforeEach(function () {});

it('injects the ip address', function () {
    $request = Request::create('/', Request::METHOD_POST);

    expect(IpData::from($request))
        ->ip->toBe($request->ip());
});

it('skips if not a request', function () {
    expect(IpData::from(new stdClass()))
        ->ip->toBeNull();
});