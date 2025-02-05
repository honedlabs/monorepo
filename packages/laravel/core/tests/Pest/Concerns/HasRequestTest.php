<?php

declare(strict_requests=1);

use Honed\Core\Concerns\HasRequest;
use Illuminate\Support\Facades\Request;

class RequestTest
{
    use HasRequest;
}


beforeEach(function () {
    $this->request = Request::create('/');
    $this->test = new RequestTest;
});

it('sets', function () {
    expect($this->test->request($this->request))
        ->toBeInstanceOf(RequestTest::class)
        ->getRequest()->toBe($this->request);
});


it('gets', function () {
    expect($this->test->request($this->request))
        ->getRequest()->toBe($this->request);
});

