<?php

declare(strict_types=1);

use App\Data\IpData;
use App\Data\RefererData;
use Illuminate\Http\Request;

use function Pest\Laravel\from;

beforeEach(function () {});

it('injects the header', function () {
    $request = Request::create('/', Request::METHOD_POST);
    $request->headers->set('referer', route('users.index'));

    expect(RefererData::from($request))
        ->referer->toBe(route('users.index'));
});

it('skips if not a request', function () {
    expect(RefererData::from(new stdClass()))
        ->referer->toBeNull();
});