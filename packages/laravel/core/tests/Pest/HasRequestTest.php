<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasRequest;
use Illuminate\Support\Facades\Request as RequestFacade;

beforeEach(function () {
    $this->test = new class {
        use HasRequest;
    };
    $this->request = RequestFacade::create('/');
});

it('accesses', function () {
    expect($this->test)
        ->getRequest()->toBeNull()
        ->request($this->request)->toBe($this->test)
        ->getRequest()->toBe($this->request);
});