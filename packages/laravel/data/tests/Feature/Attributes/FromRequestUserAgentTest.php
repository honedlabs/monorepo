<?php

declare(strict_types=1);

use App\Data\UserAgentData;
use Illuminate\Http\Request;

beforeEach(function () {});

it('injects the user agent', function () {
    $request = Request::create('/', Request::METHOD_POST);

    expect(UserAgentData::from($request))
        ->userAgent->toBe($request->userAgent());
});

it('skips if not a request', function () {
    expect(UserAgentData::from(new stdClass()))
        ->userAgent->toBeNull();
});