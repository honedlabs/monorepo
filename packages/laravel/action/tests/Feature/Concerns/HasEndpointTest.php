<?php

declare(strict_types=1);

use Honed\Action\Batch;
use Honed\Action\Concerns\HasEndpoint;
use Workbench\App\Batches\UserBatch;

beforeEach(function () {
    $this->test = new class()
    {
        use HasEndpoint;
    };
});

it('has endpoint', function () {
    expect($this->test)
        ->getEndpoint()->toBe(config('action.endpoint'))
        ->endpoint('/example')->toBe($this->test)
        ->getEndpoint()->toBe('/example')
        ->getDefaultEndpoint()->toBe(config('action.endpoint'));
});